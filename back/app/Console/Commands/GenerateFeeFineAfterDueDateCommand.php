<?php

namespace App\Console\Commands;

use App\Option;
use App\Student;
use App\StudentFeeArrear;
use App\StudentFeeTransaction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GenerateFeeFineAfterDueDateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:generate-monthly-fee-fine';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates fine for fee after due date has passed.';

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
        $fee_submission_due_date = Option::find( 'fee_submission_due_date' )->value;

        $now = Carbon::now();
        $due_date = Carbon::create( $now->year, $now->month, $fee_submission_due_date );

        // if current date is greater than due date
        // if due date has passed
        if ( $now->greaterThan( $due_date ) ) {
            $allow_automatic_fee_generate = Option::find( 'allow_automatic_fee_generate' )->value;

            // run only if automatic fee generation is 1
            if ( $allow_automatic_fee_generate == 1 ) {
                try {
                    DB::transaction( function () use ( $now, $due_date ) {
                        $student_fee_type_monthly_fee_id = Option::find( 'student_fee_type_monthly_fee_id' )->value;
                        $student_fee_type_fee_fine_id = Option::find( 'student_fee_type_fee_fine_id' )->value;

                        $students = Student::select( ['id', 'fine_generation_date_time'] )
                            ->whereDate( 'fine_generation_date_time', '<', $now->format( 'Y-m-01' ) )
                            ->orWhereNull( 'fine_generation_date_time' )
                            ->get();

                        foreach ( $students as $student ) {
                            // get student fee transactions from current month
                            // constraint transactions:
                            $studentFeeTransactionCount = StudentFeeTransaction::whereHas( 'records', function ( $query ) use ( $student_fee_type_monthly_fee_id ) {
                                $query->where( 'student_fee_type_id', $student_fee_type_monthly_fee_id );
                                $query->where( 'debit', '>', 0 );
                            } )->where( 'id', $student->id )
                                ->whereDate( 'created_at', 'like', $now->format( 'Y-m-' ) . '%' )
                                ->count();

                            // if there is no transaction found
                            if ( $studentFeeTransactionCount == 0 ) {
                                $monthlyFeeArrearOfStd = StudentFeeArrear::firstOrCreate( [
                                    'student_id' => $student->id,
                                    'student_fee_type_id' => $student_fee_type_monthly_fee_id
                                ], ['arrear' => 0] );

                                // if student's MONTHLY FEE ARREAR (fee type) is greater than 0
                                // means student didn't pay the fee
                                if ( intval( $monthlyFeeArrearOfStd->arrear ) > 0 ) {
                                    $fee_fine_after_due_date = Option::find( 'fee_fine_after_due_date' )->value;

                                    // get previous fine
                                    $studentFeeFineArrear = StudentFeeArrear::firstOrNew( [
                                        'student_id' => $student->id,
                                        'student_fee_type_id' => $student_fee_type_fee_fine_id
                                    ], ['arrear' => 0] );

                                    // add amount to the fine
                                    $studentFeeFineArrear->arrear = intval( $studentFeeFineArrear->arrear ) + intval( $fee_fine_after_due_date );
                                    $studentFeeFineArrear->save();

                                    // add transaction record of this fine
                                    $stdTransaction = StudentFeeTransaction::create( ['student_id' => $student->id] );
                                    $stdTransaction->records()->create( [
                                        'student_fee_type_id' => $student_fee_type_fee_fine_id,
                                        'credit' => $fee_fine_after_due_date,
                                        'debit' => 0,
                                        'balance' => $studentFeeFineArrear->arrear
                                    ] );

                                    // updating student's fine generation time
                                    $student->fine_generation_date_time = $now;
                                    $student->save();
                                }
                            }
                        }
                    }, 10 );

                    $this->info( 'Fine has been added for defaulter students.' );

                    Log::debug( "Fine has been generated for defaulter students" );
                } catch ( \Exception $e ) {
                    $this->error( "Failed to generate fine for monthly fee for defaulters." );

                    Log::error( "Failed to generate fine for monthly fee for defaulters.", ['error_message' => $e->getMessage(), 'error_line' => $e->getLine(), 'error' => $e] );
                }
            }
        }
    }
}
