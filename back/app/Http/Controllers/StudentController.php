<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Category;
use App\FatherRecord;
use App\Http\Requests\StudentAdmission;
use App\Libraries\SmsLibrary;
use App\Option;
use App\SchoolClass;
use App\SchoolMedium;
use App\Section;
use App\Sibling;
use App\SmsTemplate;
use App\Student;
use App\StudentAttachment;
use App\StudentFeeArrear;
use App\StudentFeeTransaction;
use App\StudentFeeType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{

    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:student_admission' )->only( ['admission', 'create'] );
        $this->middleware( 'CheckPrivilege:student_edit' )->only( 'update' );
    }

    public function index( Request $request )
    {
        $simpeTitle = "Students";
        $branches = Branch::get();
        $classes = SchoolClass::get();
        $sections = Section::get();
        $user = \Auth::user();
        $loading_image_path = Option::find( 'loading_image_path' )->value;

        $branch_id = $request->branch_id;
        $current_class_id = $request->current_class_id;
        $section_id = $request->section_id;
        $filter = $request->filter;
        $search_type = $request->search_type;
        $search_type = ( !empty( $search_type ) ? $search_type : 'active' );

        $students = Student::with( ['branch', 'currentClass', 'section', 'fatherRecord'] )
            ->getFiltered( $branch_id, $current_class_id, $section_id, $filter )
            ->orderBy( 'pin' );

        if ( in_array( $search_type, ['all', 'withdrawn'] ) ) {
            $students->withoutGlobalScope( 'notWithdrawn' );

            if ( $search_type == 'withdrawn' ) {
                $students->where( 'withdrawn', 1 );
            }
        }

        $students = $students->get();

        $students_count = [
            'total' => $students->count(),
            'male' => $students->where( 'gender', 'male' )->count(),
            'female' => $students->where( 'gender', 'female' )->count()
        ];

        $highest_pin = Student::max( 'pin' );

        $title = "{$simpeTitle} (Total: {$students_count['total']}, Male: {$students_count['male']}, Female: {$students_count['female']})";

        $permissions = [
            'promote_demote_student' => $user->userHasPrivilege( 'promote_demote_student' ),
            'send_manual_sms' => $user->userHasPrivilege( 'send_manual_sms' ),
            'update_assigned_student_class_fee' => $user->userHasPrivilege( 'update_assigned_student_class_fee' )
        ];

        $current_url = url()->current();

        return view( 'student.index', compact(
            'title',
            'simpeTitle',
            'students',
            'branches',
            'classes',
            'sections',
            'branch_id',
            'current_class_id',
            'section_id',
            'filter',
            'students_count',
            'search_type',
            'highest_pin',
            'user',
            'permissions',
            'loading_image_path',
            'current_url'
        ) );
    }

    public function admission( Student $studentEdit )
    {
        $studentEdit->load( ['fatherRecord', 'attachments', 'category'] );
        if ( $studentEdit->id !== null ) {
            $studentEdit->assigned_class_fee_final = ( $studentEdit->assigned_class_fee ?? 0 ) - ( $studentEdit->category->fee_discount ?? 0 ) - ( $studentEdit->extra_discount ?? 0 );
        }

        $title = "Student Admission";
        $user = \Auth::user();

        $branches = Branch::get();
        $classes = SchoolClass::get();
        $categories = Category::get();
        $school_mediums = SchoolMedium::get();
        $sections = Section::get();
        $currentMaxPin = Student::max( 'pin' ) + 1 ?: 1;

        // in update mode if has student ID
        $isInUpdateMode = ( $studentEdit->id === null ? false : true );

        $nextStudent = ( empty( $studentEdit->pin ) ? null : Student::where( 'pin', '>', $studentEdit->pin )->orderBy( 'pin' )->first() );
        $previousStudent = ( empty( $studentEdit->pin ) ? null : Student::where( 'pin', '<', $studentEdit->pin )->orderBy( 'pin', 'desc' )->first() );

        $options = Option::getOptionValue( ['student_fee_type_monthly_fee_id', 'student_fee_type_fee_fine_id'] );
        $student_fee_type_monthly_fee_id = $options['student_fee_type_monthly_fee_id'];
        $student_fee_type_fee_fine_id = $options['student_fee_type_fee_fine_id'];

        // getting fee types which doesn't contain the fee fine
        $studentFeeTypes = StudentFeeType::where( 'id', '!=', $student_fee_type_fee_fine_id )->get();

        $permissions = [
            'can_edit_extra_discount' => $user->userHasPrivilege( 'can_edit_extra_discount' )
        ];

        return view( 'student.admission', compact(
            'title',
            'branches',
            'classes',
            'sections',
            'school_mediums',
            'currentMaxPin',
            'isInUpdateMode',
            'studentEdit',
            'categories',
            'nextStudent',
            'previousStudent',
            'student_fee_type_monthly_fee_id',
            'studentFeeTypes',
            'permissions'
        ) );
    }

    private function convertBase64ToPNG( $image_data )
    {
        // if image data is empty
        if ( empty( $image_data ) ) {
            return false;
        } else { // image data is not empty
            $image_data = explode( ',', $image_data );

            // keep generating new file name if a file with the same name already exists
            do {
                $image_name = 'student_images/' . uniqid( str_random( 20 ) ) . '.png';
            } while ( Storage::exists( $image_name ) );

            if ( Storage::put( $image_name, base64_decode( $image_data[1] ) ) ) {
                return $image_name;
            } else {
                throw new \Exception( "Image couldn't be saved. Try again." );
            }
        }
    }

    public function create( StudentAdmission $request )
    {
        $user = \Auth::user();

        if ( $request->image === null ) {
            if ( $request->gender == 'male' ) {
                $image = Option::find( 'default_user_image_male' )->value;
            } else {
                $image = Option::find( 'default_user_image_female' )->value;
            }
        } elseif ( !empty( $request->image_capture ) ) {
            $image = $this->convertBase64ToPNG( $request->image_capture );
        } else {
            $image = $request->file( 'image' )->store( 'student_images' );
        }

        try {
            $transaction_output = \DB::transaction( function () use ( $image, $user, $request ) {
                $std_father_id = null;
                // if any of the father's inputs are given
                if ( !empty( $request->father_name )
                    || !empty( $request->father_qualification )
                    || !empty( $request->father_mobile )
                    || !empty( $request->father_sms_cell )
                    || !empty( $request->father_ptcl )
                    || !empty( $request->father_email )
                    || !empty( $request->father_profession )
                    || !empty( $request->father_job_address ) ) {

                    // if father's CNIC is available
                    if ( !empty( $request->father_cnic ) ) {
                        // find father's record with CNIC or create new instance with the CNIC
                        $fatherRecord = FatherRecord::firstOrNew( ['cnic' => $request->father_cnic] );
                    } else { // if father's CNIC is not available
                        // Make new instance of father record
                        $fatherRecord = new FatherRecord();
                    }
                    $fatherRecord->name = $request->father_name;
                    $fatherRecord->qualification = $request->father_qualification;
                    $fatherRecord->mobile = $request->father_mobile;
                    $fatherRecord->sms_cell = $request->father_sms_cell;
                    $fatherRecord->ptcl = $request->father_ptcl;
                    $fatherRecord->email = $request->father_email;
                    $fatherRecord->profession = $request->father_profession;
                    $fatherRecord->job_address = $request->father_job_address;
                    $fatherRecord->save();
                    $std_father_id = $fatherRecord->id;
                }

                $pin = intval( $request->pin );
                // keep running loop till unique pin code is obtained
                while ( Student::where( 'pin', $pin )->exists() ) {
                    $pin++;
                }

                $permissions = [
                    'can_edit_extra_discount' => $user->userHasPrivilege( 'can_edit_extra_discount' )
                ];

                $class = SchoolClass::find( $request->current_class_id );

                $student = new Student();
                $student->pin = $pin;
                $student->reg_no = $request->reg_no;
                $student->date_of_admission = ( empty( $request->date_of_admission ) ? null : Carbon::parse( $request->date_of_admission ) );
                $student->session = $request->input( 'session' );
                $student->class_of_admission_id = $request->class_of_admission_id;
                $student->branch_id = $request->branch_id;
                $student->current_class_id = $request->current_class_id;
                $student->section_id = $request->section_id;
                $student->category_id = $request->category_id;
                $student->name = $request->name;
                $student->cnic = $request->cnic;
                $student->gender = $request->gender;
                $student->religion = $request->religion;
                $student->caste = $request->caste;
                $student->blood_group = $request->blood_group;
                $student->dob = ( empty( $request->dob ) ? null : Carbon::parse( $request->dob ) );
                $student->dob_words = ( !empty( $request->dob_words ) ? $request->dob_words : ( !empty( $student->dob ) ? Carbon::parse( $student->dob )->format( 'jS \\of F Y' ) : "" ) );
                $student->father_record_id = $std_father_id;
                $student->mother_name = $request->mother_name;
                $student->mother_qualification = $request->mother_qualification;
                $student->mother_profession = $request->mother_profession;
                $student->mother_phone = $request->mother_phone;
                $student->mother_job_address = $request->mother_job_address;
                $student->home_street_address = $request->home_street_address;
                $student->city = $request->city;
                $student->colony = $request->colony;
                $student->school_medium_id = $request->school_medium_id;
                $student->speciality = $request->speciality;
                $student->note = $request->note;
                $student->assigned_class_fee = $class->fee;
                $student->withdrawn = $request->withdrawn;
                $student->image = $image;

                // only add specified extra discount value if user has privilege to edit extra discount for students
                if ( $permissions['can_edit_extra_discount'] === true ) {
                    $student->extra_discount = ( !empty( $request->extra_discount ) && $request->extra_discount > 0 ? $request->extra_discount : 0 );
                } else {
                    $student->extra_discount = 0;
                }

                $student->save();

                $attachments = $request->attachments;

                if ( !empty( $attachments ) ) {
                    foreach ( $attachments as $attachment ) {
                        if ( !empty( $attachment['title'] ) ) {
                            $student_attachment = new StudentAttachment();
                            $student_attachment->path = Storage::putFile( 'attachments', $attachment['file'] );
                            $student_attachment->student_id = $student->id;
                            $student_attachment->title = $attachment['title'];
                            $student_attachment->save();
                        }
                    }
                }

                $siblings_cnic = $request->siblings_cnic ?? [];
                $siblings_name = $request->siblings_name ?? [];
                $siblings_class = $request->siblings_class ?? [];
                $siblings_school = $request->siblings_school ?? [];
                $siblings_note = $request->siblings_note ?? [];

                $sibling_ids = [];
                for ( $i = 0; $i < count( $siblings_cnic ); $i++ ) {
                    if ( !empty( $siblings_name[$i] ) ) {
                        $sibling = Sibling::firstOrNew( ['cnic' => $siblings_cnic[$i]] );
                        $sibling->name = $siblings_name[$i];
                        $sibling->class = $siblings_class[$i];
                        $sibling->school = $siblings_school[$i];
                        $sibling->note = $siblings_note[$i];
                        $sibling->save();

                        $sibling_ids[] = $sibling->id;
                    }
                }

                $student->siblings()->sync( $sibling_ids );

                // student fee assignment
                $student_fee_types = $request->student_fee_types;
                if ( !empty( $student_fee_types ) ) {
                    $student_fee_type_monthly_fee_id = Option::getOptionValue( 'student_fee_type_monthly_fee_id' );

                    $fee_transaction_records = [];

                    foreach ( $student_fee_types as $student_fee_type ) {
                        // if fee is selected
                        if ( !empty( $student_fee_type['selected'] ) && $student_fee_type['selected'] == '1' ) {
                            // if fee type is monthly fee
                            if ( $student_fee_type['fee_type_id'] == $student_fee_type_monthly_fee_id ) {
                                // used this method because class fee has already been assigned
                                $fee_amount = $student->getFee();
                            } else { // NOT monthly fee type
                                // get user typed amount
                                $fee_amount = ( empty( $student_fee_type['fee_amount'] ) ? 0 : intval( $student_fee_type['fee_amount'] ) );
                            }

                            // only add to fee arrear if fee amount is greater than 0
                            if ( $fee_amount > 0 ) {
                                // adding fee amount in its corresponding arrear
                                $studentFeeArrear = StudentFeeArrear::firstOrNew( [
                                    'student_id' => $student->id,
                                    'student_fee_type_id' => $student_fee_type['fee_type_id']
                                ], [
                                    'arrear' => 0
                                ] );
                                $studentFeeArrear->arrear += $fee_amount;
                                $studentFeeArrear->save();

                                $fee_transaction_records[] = [
                                    'student_fee_type_id' => $student_fee_type['fee_type_id'],
                                    'credit' => $fee_amount,
                                    'balance' => $studentFeeArrear->arrear
                                ];
                            }
                        }
                    }

                    if ( !empty( $fee_transaction_records ) ) {
                        // create transaction and add its records
                        $studentFeeTransaction = StudentFeeTransaction::create( ['student_id' => $student->id] );
                        $studentFeeTransaction->records()->createMany( $fee_transaction_records );
                    }
                }

                // Try to get a phone number for sending sms
                if ( !empty( $request->father_sms_cell ) ) {
                    $number_for_sms = $request->father_sms_cell;
                } else if ( !empty( $request->father_mobile ) ) {
                    $number_for_sms = $request->father_mobile;
                } else if ( !empty( $student->mother_phone ) ) {
                    $number_for_sms = $student->mother_phone;
                } else {
                    $number_for_sms = null;
                }

                return [
                    'student_id' => $student->id,
                    'number_for_sms' => $number_for_sms
                ];
            }, 3 );
            $std_id = $transaction_output['student_id'];

            $send_automatic_sms = Option::getOptionValue( 'send_automatic_sms' );

            // if sending automatic SMS is allowed and
            // if we got number to which we have to send sms
            // send sms and if sms fails, add error message to the flash data
            if ( $send_automatic_sms == 1 && !empty( $transaction_output['number_for_sms'] ) ) {
                // get and render admission sms from db
                $sms_on_admission = Option::getOptionValue( 'sms_on_admission' );
                $smsTemplate = SmsTemplate::find( $sms_on_admission );
                $smsMessage = SmsTemplate::renderTemplateContent( $smsTemplate->template, $std_id );

                $send_sms = SmsLibrary::send_sms( [$transaction_output['number_for_sms']], $smsMessage );
                if ( $send_sms['status'] === false ) {
                    $request->session()->flash( 'err', "SMS ERROR: " . $send_sms['msg'] );
                }
            }

            $proceed_to_fee_receive = $request->proceed_to_fee_receive;
            if ( !empty( $proceed_to_fee_receive ) && $proceed_to_fee_receive == 1 ) {
                return redirect()->route( 'dashboard.student_fee.receive_fee', ['student' => $std_id] )->with( 'msg', "Student has been added." );
            } else {
                return back()->with( 'msg', "Student has been added." );
            }
        } catch ( \Exception $e ) {
            \Log::error( "Wasn't able to create new student on student admission page.", [
                'error_msg' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString()
            ] );
            return back()->with( 'err', "Something went wrong while processing student's admission. Please try again." );
        }
    }

    public function update( StudentAdmission $request )
    {
        $user = \Auth::user();

        $image = null;
        if ( $request->hasFile( 'image' ) && $request->file( 'image' )->isValid() ) {
            $image = $request->file( 'image' )->store( 'student_images' );
        } elseif ( !empty( $request->image_capture ) ) {
            $image = $this->convertBase64ToPNG( $request->image_capture );
        }

        $student = Student::findOrFail( $request->id );

        try {
            \DB::transaction( function () use ( $request, $image, $user, $student ) {
                $std_father_id = null;

                // if any of the father's inputs are given
                if ( !empty( $request->father_name )
                    || !empty( $request->father_qualification )
                    || !empty( $request->father_mobile )
                    || !empty( $request->father_sms_cell )
                    || !empty( $request->father_ptcl )
                    || !empty( $request->father_email )
                    || !empty( $request->father_profession )
                    || !empty( $request->father_job_address ) ) {

                    // if father_cnic is empty and father_record_id is null
                    if ( empty( $request->father_cnic ) && empty( $student->father_record_id ) ) {
                        $fatherRecord = new FatherRecord();
                    } else { // either father's cnic available in input or father record id is available in db
                        // if none of both are empty
                        if ( !empty( $request->father_cnic ) && !empty( $student->father_record_id ) ) {
                            $fatherRecord = FatherRecord::where( 'cnic', $request->father_cnic )->first();

                            // if father record doesn't exists with this cnic
                            if ( $fatherRecord === null ) {
                                $fatherRecord = FatherRecord::find( $student->father_record_id );
                            } else {
                                $old_father_record_id = $student->father_record_id;
                                $student->father_record_id = $fatherRecord->id;
                                $student->save();
                                FatherRecord::where( 'id', $old_father_record_id )->delete();
                            }
                        } else if ( !empty( $request->father_cnic ) ) { // if father cnic from input is not empty
                            $fatherRecord = FatherRecord::firstOrNew( ['cnic' => $request->father_cnic] );
                        } else { // if father_record_id is not empty on student record
                            $fatherRecord = FatherRecord::find( $student->father_record_id );
                        }
                    }

                    $fatherRecord->cnic = $request->father_cnic;
                    $fatherRecord->name = $request->father_name;
                    $fatherRecord->qualification = $request->father_qualification;
                    $fatherRecord->mobile = $request->father_mobile;
                    $fatherRecord->sms_cell = $request->father_sms_cell;
                    $fatherRecord->ptcl = $request->father_ptcl;
                    $fatherRecord->email = $request->father_email;
                    $fatherRecord->profession = $request->father_profession;
                    $fatherRecord->job_address = $request->father_job_address;
                    $fatherRecord->save();
                    $std_father_id = $fatherRecord->id;
                }

                $permissions = [
                    'can_edit_extra_discount' => $user->userHasPrivilege( 'can_edit_extra_discount' )
                ];

                $student->pin = $request->pin;
                $student->reg_no = $request->reg_no;
                $student->date_of_admission = ( empty( $request->date_of_admission ) ? null : Carbon::parse( $request->date_of_admission ) );
                $student->session = $request->input( 'session' );
                $student->class_of_admission_id = $request->class_of_admission_id;
                $student->branch_id = $request->branch_id;
                $student->current_class_id = $request->current_class_id;
                $student->section_id = $request->section_id;
                $student->category_id = $request->category_id;
                $student->name = $request->name;
                $student->cnic = $request->cnic;
                $student->gender = $request->gender;
                $student->religion = $request->religion;
                $student->caste = $request->caste;
                $student->blood_group = $request->blood_group;
                $student->dob = ( empty( $request->dob ) ? null : Carbon::parse( $request->dob ) );
                $student->dob_words = ( !empty( $request->dob_words ) ? $request->dob_words : Carbon::parse( $student->dob )->format( 'jS \\of F Y' ) );
                $student->father_record_id = $std_father_id;
                $student->mother_name = $request->mother_name;
                $student->mother_qualification = $request->mother_qualification;
                $student->mother_profession = $request->mother_profession;
                $student->mother_phone = $request->mother_phone;
                $student->mother_job_address = $request->mother_job_address;
                $student->home_street_address = $request->home_street_address;
                $student->city = $request->city;
                $student->colony = $request->colony;
                $student->school_medium_id = $request->school_medium_id;
                $student->speciality = $request->speciality;
                $student->note = $request->note;

                // if image is available and uploaded. Update the column too.
                if ( $image !== null ) {
                    $student->image = $image;
                }

                // allowing to save user specified extra discount only if logged in user has privilege of that.
                if ( $permissions['can_edit_extra_discount'] === true ) {
                    $student->extra_discount = ( !empty( $request->extra_discount ) && $request->extra_discount > 0 ? $request->extra_discount : 0 );
                } else {
                    $student->extra_discount = 0;
                }

                //$student->withdrawn = $request->withdrawn;
                $student->save();

                $attachments = $request->attachments;

                if ( !empty( $attachments ) ) {
                    foreach ( $attachments as $attachment ) {
                        if ( !empty( $attachment['title'] ) ) {
                            $student_attachment = new StudentAttachment();
                            $student_attachment->path = Storage::putFile( 'attachments', $attachment['file'] );
                            $student_attachment->student_id = $student->id;
                            $student_attachment->title = $attachment['title'];
                            $student_attachment->save();
                        }
                    }
                }

                $siblings_cnic = $request->siblings_cnic ?? [];
                $siblings_name = $request->siblings_name;
                $siblings_class = $request->siblings_class;
                $siblings_school = $request->siblings_school;
                $siblings_note = $request->siblings_note;

                $sibling_ids = [];
                for ( $i = 0; $i < count( $siblings_cnic ); $i++ ) {
                    if ( !empty( $siblings_name[$i] ) ) {
                        $sibling = Sibling::firstOrNew( ['cnic' => $siblings_cnic[$i]] );
                        $sibling->name = $siblings_name[$i];
                        $sibling->class = $siblings_class[$i];
                        $sibling->school = $siblings_school[$i];
                        $sibling->note = $siblings_note[$i];
                        $sibling->save();

                        $sibling_ids[] = $sibling->id;
                    }
                }

                $student->siblings()->sync( $sibling_ids );
            }, 3 );

            return back()->with( 'msg', "Student Details have been updated!" );
        } catch ( \Exception $e ) {
            \Log::error( "Wasn't able to update student information.", [
                'err_msg' => $e->getMessage(),
                'err_trace' => $e->getTraceAsString()
            ] );
            return back()->with( 'err', "Something went wrong while updating student records. Please try again." );
        }
    }
}
