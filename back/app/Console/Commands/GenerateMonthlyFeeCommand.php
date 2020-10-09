<?php

namespace App\Console\Commands;

use App\Option;
use App\Student;
use App\StudentFeeArrear;
use App\StudentFeeTransaction;
use App\StudentFeeTransactionRecord;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateMonthlyFeeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:generate-monthly-fee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate monthly fee of students';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::debug( "Generate monthly fee command ran." );

        $now = now();
        $currentMonth = Carbon::create( $now->year, $now->month, 1 );

        $allow_automatic_fee_generate = Option::find( 'allow_automatic_fee_generate' )->value;

        // run only if automatic fee generation is 1
        if ( $allow_automatic_fee_generate == 1 ) {
            try {
                \DB::transaction( function () use ( $now, $currentMonth ) {
                    $monthly_fee_type_id = Option::find( 'student_fee_type_monthly_fee_id' )->value;

                    // getting students with fee generation date of previous month
                    $students = Student::with( ['currentClass', 'category'] )
                        ->whereDate( 'fee_generation_date_time', '<', $currentMonth->toDateString() )
                        ->orWhereNull( 'fee_generation_date_time' )->get();

                    foreach ( $students as $student ) {
                        // getting payable fee of student
                        $fee = $student->getFee();

                        // incrementing fee arrears of student with this fee amount
                        $studentFeeArrear = StudentFeeArrear::firstOrNew( [
                            'student_id' => $student->id,
                            'student_fee_type_id' => $monthly_fee_type_id
                        ], ['arrear' => 0] );
                        $studentFeeArrear->arrear = intval( $studentFeeArrear->arrear ) + $fee;
                        $studentFeeArrear->save();

                        // generating transaction details
                        $studentFeeTransaction = StudentFeeTransaction::create( [
                            'student_id' => $student->id,
                            'description' => "Generating fee for month " . $now->format( 'F' ) . "."
                        ] );

                        // adding fee record for the transaction
                        StudentFeeTransactionRecord::create( [
                            'student_fee_transaction_id' => $studentFeeTransaction->id,
                            'student_fee_type_id' => $monthly_fee_type_id,
                            'credit' => $fee,
                            'debit' => 0,
                            'balance' => $studentFeeArrear->arrear
                        ] );
                    }

                    // if there are some students found whose fee wasn't already generated
                    // updating fee generation times
                    if ( $students->isNotEmpty() ) {
                        // update fee generation time in options table
                        Option::where( 'name', 'students_last_fee_generation_date_time' )->update( ['value' => $now->toDateTimeString()] );

                        // Updating every student's fee_generation_date_time for whom fee was generated
                        Student::whereIn( 'id', $students->pluck( 'id' ) )->update( ['fee_generation_date_time' => $now] );

                        // logging
                        $this->info( "Fee has been generated for all the students." );
                    } else {
                        $this->info("There were no students whose fee could be update.");
                    }

                    \Log::debug( "Monthly fee generation for students completed", [
                        'dateTime' => $now->toDateTimeString(),
                        'student_ids' => $students->pluck( 'id' )
                    ] );
                }, 10 );
            } catch ( \Exception $e ) {
                \Log::error( "Automatic fee generation from the cron job failed!!!", ['errorMessage' => $e->getMessage(), 'time' => $now->toDateTimeString()] );
            }
        }
    }
}
