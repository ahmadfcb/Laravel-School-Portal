<?php

namespace App\Http\Controllers;

use App\Libraries\UrlLibrary;
use App\Student;
use App\StudentFeeArrear;
use App\StudentFeeTransaction;
use App\StudentFeeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentFeeReceiveController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:receive_fee' );
    }

    public function index( Student $student )
    {
        $student->load( ['branch', 'currentClass', 'section', 'category'] );

        UrlLibrary::storeOrKeepBackUrl();

        $title = "Receive Fee";

        $feeTypes = StudentFeeType::with( [
            'studentFeeArrears' => function ( $query ) use ( $student ) {
                $query->where( 'student_id', $student->id );
            }
        ] )->get();

        $studentFeeTransactions = StudentFeeTransaction::with( ['records.studentFeeType'] )
            ->where( 'student_id', $student->id )
            ->latest()->get();

        // class fee - category discount - extra discount
        $payableFee = $student->getFee();

        $redirectUrl = UrlLibrary::getBackUrl();

        return view( 'student_fee_receive.index', compact(
            'title',
            'student',
            'feeTypes',
            'studentFeeTransactions',
            'payableFee',
            'redirectUrl'
        ) );
    }

    public function receiveProcess( Request $request, Student $student )
    {
        $this->validate( $request, [
            'fee_types' => 'required',
            'fee_types.*.fee_type_id' => 'required|integer|exists:student_fee_types,id',
            'fee_types.*.value' => 'nullable|integer|min:0',
            'btn_name' => 'required|in:save,print'
        ] );

        $fee_types = $request->fee_types;
        $sum=0;

        try {
            $studentFeeTransactionId = DB::transaction( function () use ( $student, $fee_types ) {
                $transaction_record_array = [];

                foreach ( $fee_types as $fee_type ) {
                    if ( !empty( $fee_type['value'] ) ) {
                        $studentFeeArrears = StudentFeeArrear::firstOrNew( [
                            'student_id' => $student->id,
                            'student_fee_type_id' => $fee_type['fee_type_id']
                        ] );

                        if ( isset( $studentFeeArrears->arrear ) ) {
                            $studentFeeArrears->arrear = intval( $studentFeeArrears->arrear ) - intval( $fee_type['value'] );
                        } else {
                            $studentFeeArrears->arrear = 0;
                        }
                        $studentFeeArrears->save();

                        $transaction_record_array[] = [
                            'student_fee_type_id' => $fee_type['fee_type_id'],
                            'credit' => 0,
                            'debit' => $fee_type['value'],
                            'balance' => $studentFeeArrears->arrear
                        ];
                    }
                }

                $studentFeeTransaction = StudentFeeTransaction::create( [
                    'student_id' => $student->id,
                    'description' => "Received cash"
                ] );
                $studentFeeTransaction->records()->createMany( $transaction_record_array );

                return $studentFeeTransaction->id;
            } );

            // if form submitted with print button
            if ( $request->btn_name == 'print' ) {
                $url = url()->route( 'dashboard.student_fee.transaction', ['studentFeeTransaction' => $studentFeeTransactionId] );
            } else { // if form submitted with save button
                // fallback url
                $url = url()->route( 'dashboard.student_fee.receive_fee', ['student' => $student->id] );
                // redirecting back to the page from where user came with fallback URL
                $url = UrlLibrary::getBackUrl( $url );
            }
            return redirect( $url );
        } catch ( \Exception $e ) {
            Log::error( "Wan't able to receive fee of a student", ['error_message' => $e->getMessage(), 'fee_types' => $fee_types] );
            return back()->with( 'err', 'Something went wrong! Please try again later.' );
        }

    }

    public function feeRemissionProcess( Request $request, Student $student )
    {
        $this->validate( $request, [
            'fee_types' => 'required',
            'fee_types.*.fee_type_id' => 'required|integer|exists:student_fee_types,id',
            'fee_types.*.remission_amount' => 'nullable|integer|min:0'
        ] );

        $fee_types = $request->fee_types;

        try {
            $transactionCreated = DB::transaction( function () use ( $fee_types, $student ) {
                $remission_records_array = [];

                foreach ( $fee_types as $fee_type ) {
                    if ( !empty( $fee_type['remission_amount'] ) && intval( $fee_type['remission_amount'] ) > 0 ) {
                        $studentFeeArrears = StudentFeeArrear::firstOrNew( [
                            'student_id' => $student->id,
                            'student_fee_type_id' => $fee_type['fee_type_id']
                        ], ['arrear' => null] );

                        // if arrear is not null means it exists and it is greater than 0 means no advance payments exists
                        // apply remission, subtract remission amount from the arrear. if arrear goes below 0, assign it 0.
                        if ( $studentFeeArrears->arrear !== null && intval( $studentFeeArrears->arrear ) > 0 ) {
                            $studentFeeArrears->arrear = intval( $studentFeeArrears->arrear ) - intval( $fee_type['remission_amount'] );
                            $studentFeeArrears->arrear = ( $studentFeeArrears->arrear < 0 ? 0 : $studentFeeArrears->arrear );
                            $studentFeeArrears->save();

                            // Remission is given, adding it to the remission column of fee transaction record
                            $remission_records_array[] = [
                                'student_fee_type_id' => $fee_type['fee_type_id'],
                                'credit' => 0,
                                'debit' => 0,
                                'remission' => intval( $fee_type['remission_amount'] ),
                                'balance' => $studentFeeArrears->arrear
                            ];
                        }
                    }
                }

                // make transaction only if there are some entries in remission records and associate those records with that.
                if ( !empty( $remission_records_array ) ) {
                    $studentFeeTransaction = StudentFeeTransaction::create( [
                        'student_id' => $student->id,
                        'description' => "Fee Remission"
                    ] );

                    $studentFeeTransaction->records()->createMany( $remission_records_array );

                    // transaction created
                    return true;
                } else {
                    // transaction wasn't created
                    return false;
                }
            } );

            if ( $transactionCreated === true ) {
                return back()->with( 'msg', "Fee remission(s) allotted to the student." );
            } else {
                return back()->with( 'err', "No fee remissions were allotted to the student either because of missing values or the student already had advance payment." );
            }
        } catch ( \Exception $e ) {
            Log::error( "Wasn't able to add fee remissions for the student", ['error_message' => $e->getMessage(), 'error_line' => $e->getLine()] );
            return back()->with( 'err', "Something went wrong! Please try again later." );
        }
    }

    public function massReceiveForm()
    {
        $title = "Mass Fee Receive";

        return view( 'student_fee_receive.mass_receive_form', compact(
            'title'
        ) );
    }

    public function massReceiveFormProcess( Request $request )
    {
        $this->validate( $request, [
            'pin' => 'required|integer|exists:students,pin'
        ] );

        // remembering previous URL
        UrlLibrary::storeOrKeepBackUrl();

        $student = Student::select( 'id' )->where( 'pin', $request->pin )->first();

        if ( !empty( $student ) ) {
            return redirect()->route( 'dashboard.student_fee.receive_fee', ['student' => $student->id] );
        } else {
            return back()->with( 'err', "Provided PIN isn't attached to any student." );
        }
    }

    public function SumOfAll()
    {

    }
}
