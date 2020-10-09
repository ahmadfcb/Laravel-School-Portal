<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
   
Route::get('/strength','ClassStrength@index');
Route::redirect( '/', url( 'login' ) );

Auth::routes();
Route::get( 'logout', 'Auth\LoginController@logout' );

Route::redirect( '/home', url( 'dashboard' ) );

Route::prefix( 'dashboard' )->middleware( ['auth'] )->group( function () {

    Route::get( '/', 'HomeController@index' )->name( 'home' );
//	Route::get( '/', 'FeeDefaulterStudentController@index' )->name( 'home' );

    Route::get( 'change-account-details', 'UserController@changeAccountDetails' )->name( 'dashboard.users.change_account_details' );
    Route::post( 'update-basic-info', 'UserController@updateBasicInfo' )->name( 'dashboard.users.update_basic_info' );
    Route::post( 'update-password', 'UserController@updatePassword' )->name( 'dashboard.users.update_password' );

    Route::prefix( 'users' )->group( function () {
        Route::get( '/{editUser?}', 'UserController@index' )->name( 'dashboard.users' );
        Route::post( '/', 'UserController@create' );
        Route::put( '/', 'UserController@update' );

        Route::get( '/{user}/delete', 'UserController@delete' )->name( 'dashboard.users.delete' );

        Route::get( '/{user}/privilege', 'PrivilegeController@privilege' )->name( 'dashboard.users.privilege' );
        Route::post( '/{user}/privilege', 'PrivilegeController@attach' );
    } );

    Route::prefix( 'branch' )->group( function () {
        Route::get( '/{branchEdit?}', 'BranchController@index' )->name( 'dashboard.branch' );
        Route::post( '/{branchEdit?}', 'BranchController@add' );
        Route::get( '/{branch}/delete', 'BranchController@delete' )->name( 'dashboard.branch.delete' );
    } );

    Route::prefix( 'category' )->group( function () {
        Route::get( '/{categoryEdit?}', 'CategoryController@index' )->name( 'dashboard.category' );
        Route::post( '/{categoryEdit?}', 'CategoryController@add' );
        Route::get( '/{category}/delete', 'CategoryController@delete' )->name( 'dashboard.category.delete' );
    } );

    Route::prefix( 'subject' )->group( function () {
        Route::get( '/{subjectEdit?}', 'SubjectController@index' )->name( 'dashboard.subject' );

        Route::post( '/', 'SubjectController@store' );
        Route::put( '/', 'SubjectController@update' );

        Route::get( '/{subject}/delete', 'SubjectController@remove' )->name( 'dashboard.subject.delete' );
    } );

    Route::prefix( 'section' )->group( function () {
        Route::get( '/{sectionEdit?}', 'SectionController@index' )->name( 'dashboard.section' );

        Route::post( '/', 'SectionController@store' );
        Route::put( '/', 'SectionController@update' );

        Route::get( '/{section}/delete', 'SectionController@remove' )->name( 'dashboard.section.delete' );
    } );

    Route::prefix( 'class' )->group( function () {
        Route::get( 'update-assigned-class-fee', 'ClassController@updateAssignedClassFee' )->name( 'dashboard.class.update_assigned_class_fee' );

        Route::get( '/{classEdit?}', 'ClassController@index' )->name( 'dashboard.class' );

        Route::post( '/', 'ClassController@store' );
        Route::put( '/', 'ClassController@update' );

        Route::get( '/{class}/delete', 'ClassController@remove' )->name( 'dashboard.class.delete' );
    } );

    Route::prefix( 'student' )->group( function () {
        Route::get( '/', 'StudentController@index' )->name( 'dashboard.student' );

        Route::get( '/admission/{studentEdit?}', 'StudentController@admission' )->name( 'dashboard.student.admission' );
        Route::post( '/admission', 'StudentController@create' );
        Route::put( '/admission', 'StudentController@update' );

        Route::get( '/card-print', 'StudentCardController@print' )->name( 'dashboard.student.card.print' );

        Route::prefix( '{student}/edit-fee-fine' )->group( function () {
            Route::get( '/', 'StudentFeeFineController@editStudentFeeFinePage' )->name( 'dashboard.student.edit_fee_fine' );
            Route::post( 'save-fee-fine-arrears', 'StudentFeeFineController@saveFeeFineArrears' )->name( 'dashboard.student.edit_fee_fine.save_fee_fine_arrears' );
        } );

        Route::prefix( 'promote-demote' )->group( function () {
            Route::get( '/', 'PromoteDemoteStudentsController@index' )->name( 'dashboard.student.promote_demote' );
            Route::post( '/', 'PromoteDemoteStudentsController@process' );
        } );
    } );

    Route::prefix( 'subject-assignment' )->group( function () {
        Route::get( '/{editItem?}', 'SubjectAssignController@index' )->name( 'dashboard.subject_assignment' );
        Route::post( '/', 'SubjectAssignController@store' );
        Route::put( '/', 'SubjectAssignController@update' );
    } );

    Route::prefix( 'student-attachment' )->group( function () {
        Route::get( '{studentAttachment}/delete', 'AttachmentController@delete' )->name( 'dashboard.student_attachment.delete' );
    } );

    Route::prefix( 'attendance-type' )->group( function () {
        Route::get( '/{editItem?}', 'AttendanceTypeController@index' )->name( 'dashboard.attendance_type' );
        Route::post( '/', 'AttendanceTypeController@store' );
        Route::put( '/', 'AttendanceTypeController@update' );

        Route::get( '/{studentAttendanceType}/delete', 'AttendanceTypeController@remove' )->name( 'dashboard.attendance_type.delete' );
    } );

    Route::prefix( 'student-attendance' )->group( function () {
        Route::get( '/', 'StudentAttendanceController@index' )->name( 'dashboard.student_attendance' );
        Route::post( '/', 'StudentAttendanceController@markAttendance' );

        Route::get( '/report', 'StudentAttendanceController@report' )->name( 'dashboard.student_attendance.report' );

        Route::get( '/report/{student}', 'StudentAttendanceController@studentReport' )->name( 'dashboard.student_attendance.student_report' );
    } );

    Route::prefix( 'option' )->group( function () {
        Route::get( '/', 'OptionController@index' )->name( 'dashboard.option' );
        Route::post( '/', 'OptionController@save' );
    } );

    Route::prefix( 'performance-scale' )->group( function () {
        Route::get( '/{editItem?}', 'PerformanceScaleController@index' )->name( 'dashboard.performance_scale' );
        Route::post( '/', 'PerformanceScaleController@store' );
        Route::put( '/', 'PerformanceScaleController@update' );

        Route::get( '/{performanceScale}/delete', 'PerformanceScaleController@remove' )->name( 'dashboard.performance_scale.delete' );
    } );

    Route::prefix( 'performance-type' )->group( function () {
        Route::get( '/{editItem?}', 'PerformanceTypeController@index' )->name( 'dashboard.performance_type' );
        Route::post( '/', 'PerformanceTypeController@store' );
        Route::put( '/', 'PerformanceTypeController@update' );

        Route::get( '/{performanceType}/delete', 'PerformanceTypeController@remove' )->name( 'dashboard.performance_type.delete' );
    } );

    Route::prefix( 'student-performance' )->group( function () {
        Route::get( '/', 'StudentPerformanceController@index' )->name( 'dashboard.student_performance' );
        Route::post( '/', 'StudentPerformanceController@mark' );

        Route::get( '/report', 'StudentPerformanceController@report' )->name( 'dashboard.student_performance.report' );

        Route::get( '/report/{student}', 'StudentPerformanceController@studentReport' )->name( 'dashboard.student_performance.student_report' );
    } );

    Route::prefix( 'student-withdraw' )->group( function () {
        Route::get( '/{student}', 'StudentWithdrawController@index' )->name( 'dashboard.student_withdraw' );
        Route::post( '/{student}', 'StudentWithdrawController@withdraw' );
    } );

    Route::prefix( 'student-readmission' )->group( function () {
        Route::get( '/{student}', 'ReadmissionController@index' )->name( 'dashboard.readmission' );
        Route::post( '/{student}', 'ReadmissionController@withdraw' );
    } );

    Route::prefix( 'attendance-sheet' )->group( function () {
        Route::get( '/', 'AttendanceSheetController@show' )->name( 'dashboard.attendance_sheet' );
        Route::get( '/print', 'AttendanceSheetController@print' )->name( 'dashboard.attendance_sheet.print' );
    } );

    Route::prefix( 'character-certificate' )->group( function () {
        Route::get( '/', 'CharacterCertificateController@index' )->name( 'dashboard.character_certificate' );
        Route::post( '/print', 'CharacterCertificateController@print' )->name( 'dashboard.character_certificate.print' );
    } );

    Route::prefix( 'leave-certificate' )->group( function () {
        Route::get( '/', 'LeaveCertificateController@index' )->name( 'dashboard.leave_certificate' );
        Route::post( '/print', 'LeaveCertificateController@print' )->name( 'dashboard.leave_certificate.print' );
    } );

    Route::prefix( 'print-sheet' )->group( function () {
        Route::get( '/view', 'PrintSheetController@printSheetView' )->name( 'dashboard.print_sheet.view' );
        Route::post( '/view/print', 'PrintSheetController@printSheetPrint' )->name( 'dashboard.print_sheet.print' );

        Route::get( '/{printSheetColumnEdit?}', 'PrintSheetController@index' )->name( 'dashboard.print_sheet' );
        Route::post( '/{printSheetColumnEdit?}', 'PrintSheetController@add' );
        Route::get( '/{printSheetColumn}/delete', 'PrintSheetController@delete' )->name( 'dashboard.print_sheet.delete' );
    } );

    Route::prefix( 'student-fee' )->group( function () {
        Route::get( 'fee-defaulters-list', 'FeeDefaulterStudentController@index' )->name( 'dashboard.student_fee.fee_defaulters_list' );
		Route::get( 'fee-defaulters-list', 'FeeDefaulterStudentController@index' )->name( 'dashboard.student_fee.fee_defaulters_list' );

        Route::get( '/generate-fee', 'StudentFeeGeneration@manualGeneration' )->name( 'dashboard.student_fee.generate' );
        Route::post( '/generate-fee', 'StudentFeeGeneration@manualGenerationProcess' );

        Route::get( '/edit-fee-fine-arrears-multiple', 'StudentFeeFineController@editMultiple' )->name( 'dashboard.student_fee_fine_arrears_multiple' );
        Route::post( '/edit-fee-fine-arrears-multiple', 'StudentFeeFineController@editMultipleUpdate' );

        Route::prefix( 'types' )->group( function () {
            Route::get( '/{studentFeeTypeEdit?}', 'StudentFeeTypeController@index' )->name( 'dashboard.student_fee.type' );
            Route::post( '/{studentFeeTypeEdit?}', 'StudentFeeTypeController@add' );
            Route::get( '/{studentFeeType}/delete', 'StudentFeeTypeController@delete' )->name( 'dashboard.student_fee.type.delete' );
        } );

        Route::prefix( 'receive-fee' )->group( function () {
            Route::get( '/mass', 'StudentFeeReceiveController@massReceiveForm' )->name( 'dashboard.student_fee.receive_fee.mass' );
            Route::post( '/mass', 'StudentFeeReceiveController@massReceiveFormProcess' );

            Route::get( '/{student}', 'StudentFeeReceiveController@index' )->name( 'dashboard.student_fee.receive_fee' );
            Route::post( '/{student}', 'StudentFeeReceiveController@receiveProcess' );
        } );

        Route::prefix( 'fee-remission' )->group( function () {
            Route::post( '/{student}', 'StudentFeeReceiveController@feeRemissionProcess' )->name( 'dashboard.student_fee.fee_remission' );
        } );

        Route::prefix( 'transaction' )->group( function () {
            Route::get( 'all', 'StudentFeeTransactionController@allTransactions' )->name( 'dashboard.student_fee.transaction.all' );

            Route::get( '/{studentFeeTransaction}', 'StudentFeeTransactionController@index' )->name( 'dashboard.student_fee.transaction' );
 
            Route::get( '/{studentFeeTransaction}/delete', 'StudentFeeTransactionController@deleteTransaction' )->name( 'dashboard.student_fee.transaction.delete' );
        } );

        Route::prefix( 'assign' )->group( function () {
            Route::get( '/', 'StudentFeeAssignController@index' )->name( 'dashboard.student_fee.assign' );
            Route::post( '/', 'StudentFeeAssignController@process' );
        } );

    } );

    Route::prefix( 'sms' )->group( function () {
        Route::prefix( 'templates' )->group( function () {
            Route::get( '/{smsTemplateEdit?}', 'SmsTemplateController@index' )->name( 'dashboard.sms.templates' );
            Route::post( '/{smsTemplateEdit?}', 'SmsTemplateController@add' );
            Route::get( '/{smsTemplate}/delete', 'SmsTemplateController@delete' )->name( 'dashboard.sms.templates.delete' );
        } );

        Route::prefix( 'manual' )->group( function () {
            Route::get( '/', 'ManualSmsController@index' )->name( 'dashboard.sms.manual' );
            Route::post( '/', 'ManualSmsController@sendSMS' );
        } );
    } );
     Route::prefix( 'reports' )->group( function () {
    Route::get('/', 'AdminReportsController@index' )->name( 'dashboard.reports' );
    Route::post( '/', 'AdminReportsController@searchID' );
    Route::get( '/{student}', 'AdminReportsController@show' )->name( 'dashboard.student_report' );
   Route::post( '/{student}', 'AdminReportsController@fee' );
    //Route::get( '/{student}', 'AdminReportsController@index' )->name( 'dashboard.reports' );
 });
Route::prefix( 'test' )->group( function () {
    Route::get('/', 'StudentTest@index' )->name( 'dashboard.test' );
    Route::post( '/', 'StudentTest@markMarks' );

});

} );
