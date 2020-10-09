<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentAdmission extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rtn = [
            'id' => 'nullable',
            'pin' => ['required', 'numeric'],
            'reg_no' => ['nullable', 'string', 'max:50'],
            'date_of_admission' => 'nullable',
            'session' => 'nullable',
            'class_of_admission_id' => 'nullable',
            'branch_id' => 'nullable|numeric|exists:branches,id',
            'current_class_id' => 'nullable|numeric|exists:classes,id',
            'section_id' => 'nullable|numeric|exists:sections,id',
            'category_id' => 'nullable|numeric|exists:categories,id',
            'extra_discount' => 'nullable|numeric|min:0',
            'name' => 'required',
            'cnic' => ['nullable', 'numeric', 'digits:13'],
            'gender' => 'required|in:male,female',
            'religion' => 'nullable|string',
            'caste' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'dob' => 'nullable|date',
            'dob_words' => 'nullable|string',
            'father_cnic' => 'nullable|numeric|digits:13',
            'father_name' => 'nullable|string',
            'father_qualification' => 'nullable|string',
            'father_mobile' => 'nullable',
            'father_sms_cell' => 'nullable',
            'father_ptcl' => 'nullable',
            'father_email' => 'nullable|string',
            'father_profession' => 'nullable|string',
            'father_job_address' => 'nullable|string',
            'mother_name' => 'nullable|string',
            'mother_qualification' => 'nullable|string',
            'mother_profession' => 'nullable|string',
            'mother_phone' => 'nullable|string',
            'mother_job_address' => 'nullable|string',
            'home_street_address' => 'nullable|string',
            'city' => 'nullable|string',
            'colony' => 'nullable|string',
            'school_medium_id' => 'nullable|string',
            'speciality' => 'nullable|string',
            'note' => 'nullable|string',
            'attachments.*.title' => 'required_with:attachments.*.file',

            'siblings_cnic.*' => 'nullable',
            'siblings_name.*' => 'required',
            'siblings_class.*' => 'nullable',
            'siblings_school.*' => 'nullable',
            'siblings_note.*' => 'nullable'
        ];

        // if creating student admission
        if ( $this->isMethod( 'post' ) ) {
            $rtn['cnic'][] = Rule::unique( 'students', 'cnic' );
            $rtn['reg_no'][] = Rule::unique( 'students', 'reg_no' );
            $rtn['withdrawn'] = 'required';

            // Student fee types validations
            $rtn['student_fee_types'] = 'nullable';
            $rtn['student_fee_types.*.fee_type_id'] = 'nullable|integer|exists:student_fee_types,id';
            $rtn['student_fee_types.*.selected'] = 'nullable|integer|in:1';
            $rtn['student_fee_types.*.fee_amount'] = 'nullable|integer|min:0';
        } else if ( $this->isMethod( 'put' ) ) { // if updating student info
            $rtn['id'] = 'required|exists:students,id';
            $rtn['cnic'][] = Rule::unique( 'students', 'cnic' )->ignore( $this->input( 'id' ) );
            $rtn['pin'][] = Rule::unique( 'students', 'pin' )->ignore( $this->input( 'id' ) );
            $rtn['reg_no'][] = Rule::unique( 'students', 'reg_no' )->ignore( $this->input( 'id' ) );
        }

        return $rtn;
    }

    public function messages()
    {
        return [
            'attachments.*.title.required_with' => 'Title is required for all the provided attachments'
        ];
    }

    public function attributes()
    {
        return [
            'reg_no' => 'Registration Number',
            'class_of_admission_id' => 'Class of Admission',
            'branch_id' => 'Branch',
            'current_class_id' => 'Current Class',
            'section_id' => 'Section',
            'school_medium_id' => 'School Medium',
        ];
    }
}
