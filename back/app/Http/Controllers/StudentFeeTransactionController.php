<?php

namespace App\Http\Controllers;

use App\Branch;
use App\SchoolClass;
use App\Section;
use App\Student;
use App\StudentFeeArrear;
use App\StudentFeeTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentFeeTransactionController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:student_fee_transaction_view_single' )->only( 'index' );
        $this->middleware( 'CheckPrivilege:student_fee_transaction_view_all' )->only( 'allTransactions' );
        $this->middleware( 'CheckPrivilege:student_fee_transaction_delete' )->only( 'deleteTransaction' );
    }

    public function index( StudentFeeTransaction $studentFeeTransaction )
    {
        $studentFeeTransaction->load( [
            'student.branch',
            'student.currentClass',
            'student.section',
            'student.category',
            'student.fatherRecord',
            'records.studentFeeType'
        ] );

        $title = "Student Fee Transaction";
        $showPrintButtons = true;

        //dd( $studentFeeTransaction->student );

        return view( 'student_fee_transaction.index', compact(
            'title',
            'showPrintButtons',
            'studentFeeTransaction'
        ) );
    }

    public function allTransactions( Request $request )
    {
        $title = "All Student Fee Transactions";

        $deposit_transactions = $request->deposit_transactions;
        $add_transaction = $request->add_transaction;
        // if both are selected
        if ( $deposit_transactions == 1 && $add_transaction == 1 ) {
            $deposit_transactions = 0;
            $add_transaction = 0;
        }

        $expand_stats = ( $request->expand_stats == 1 ? true : false );

        $date_from = $request->date_from;
        $date_from = ( empty( $date_from ) ? Carbon::now() : Carbon::parse( $date_from ) );

        $date_to = $request->date_to;
        $date_to = ( empty( $date_to ) ? Carbon::now() : Carbon::parse( $date_to ) );

        $date_diff = $date_from->diffForHumans( $date_to, true );
        $date_diff_days = $date_from->diffInDays( $date_to );

        $branch_id = $request->branch_id;
        $current_class_id = $request->current_class_id;
        $section_id = $request->section_id;
        $branches = Branch::get();
        $classes = SchoolClass::get();
        $sections = Section::get();

        $students = Student::select( 'id', 'branch_id', 'current_class_id', 'section_id' )
            ->getFiltered( $branch_id, $current_class_id, $section_id )->get();

        // bring statistics logics
        $statistics = $this->statistics( $branches, $classes, $sections, $students, $branch_id, $current_class_id, $section_id, $date_from, $date_to );

        // select all the transactions
        $studentFeeTransactions = StudentFeeTransaction::with( [
            'records',
            'student.branch',
            'student.currentClass',
            'student.section',
            'student.feeArrears' => function ( $query ) {
                $query->where( 'arrear', '>', 0 );
            }
        ] )
            ->whereDate( 'created_at', '>=', $date_from->format( 'Y-m-d' ) )
            ->whereDate( 'created_at', '<=', $date_to->format( 'Y-m-d' ) );

        // if deposit transaction is checked, add where condition to transaction records to contain records which have debit greater than 0
        if ( $deposit_transactions == 1 ) {
            $studentFeeTransactions->whereHas( 'records', function ( $query ) {
                $query->where( 'debit', '>', 0 );
            } );
        }
        // if add transaction is checked, add where condition to transaction records to contain records which have credit greater than 0
        if ( $add_transaction == 1 ) {
            $studentFeeTransactions->whereHas( 'records', function ( $query ) {
                $query->where( 'credit', '>', 0 );
            } );
        }
        // if both of above checkboxes are not selected
        // add credit and debit both greater than 0 requirement
        // this will make sure only the transactions with some amount are selected
        if ( $deposit_transactions == 0 && $add_transaction == 0 ) {
            $studentFeeTransactions->whereHas( 'records', function ( $query ) {
                $query->where( 'credit', '>', 0 );
                $query->orWhere( 'debit', '>', 0 );
            } );
        }

        $studentFeeTransactions = $studentFeeTransactions->latest()->whereIn( 'student_id', $students->pluck( 'id' ) )->get();

        $totals = [
            'credit' => 0,
            'debit' => 0,
            'total_fee_arrears' => 0
        ];

        // looping over fee transactions to calculate total credit and debit amount
        for ( $i = 0; $i < count( $studentFeeTransactions ); $i++ ) {
            $studentFeeTransaction = $studentFeeTransactions[$i];

            $totals['credit'] += $studentFeeTransaction->records->sum( 'credit' );
            $totals['debit'] += $studentFeeTransaction->records->sum( 'debit' );

            // calculating total fee arrears
            $total_fee_arrears = $studentFeeTransactions[$i]->student->feeArrears->sum( 'arrear' );
            $studentFeeTransactions[$i]->student->total_fee_arrears = $total_fee_arrears;

            // adding total fee arrears for a student to the total of all students
            $totals['total_fee_arrears'] += $total_fee_arrears;
        }

        return view( 'student_fee_transaction.all_transactions', compact(
            'title',
            'date_from',
            'date_to',
            'date_diff',
            'date_diff_days',
            'studentFeeTransactions',
            'deposit_transactions',
            'add_transaction',
            'totals',
            'branch_id',
            'current_class_id',
            'section_id',
            'branches',
            'classes',
            'sections',
            'expand_stats',
            'statistics'
        ) );
    }

    private function statistics( $branches, $classes, $sections, $students, $branch_id, $current_class_id, $section_id, $date_from, $date_to )
    {
        $show_branches_stats = false;
        $show_class_stats = false;
        $show_section_stats = false;

        $students->load( [
            'feeArrears' => function ( $query ) {
                $query->where( 'arrear', '>', 0 );
            },
            'feeTransactions' => function ( $query ) use ( $date_from, $date_to ) {
                $query->whereDate( 'created_at', '>=', $date_from->toDateString() );
                $query->whereDate( 'created_at', '<=', $date_to->toDateString() );
            },
            'feeTransactions.records'
        ] );

        if ( $branch_id === null && $current_class_id === null && $section_id === null ) { // if none is selected
            $show_branches_stats = true;

            for ( $i = 0; $i < count( $branches ); $i++ ) {
                $branch_students = $students->where( 'branch_id', $branches[$i]->id );

                // for calculating arrears for a branch
                $branches[$i]->arrear = $branch_students->pluck( 'feeArrears.*.arrear' )->sum( function ( $sum ) {
                    return collect( $sum )->sum();
                } );

                $for_credit_debit = $branch_students->pluck( 'feeTransactions.*.records' );

                // for calculating credit
                $branches[$i]->credit = $for_credit_debit->pluck( '*.*.credit' )->sum( function ( $sum ) {
                    return collect( $sum )->sum();
                } );

                // for calculating total debit
                $branches[$i]->debit = $for_credit_debit->pluck( '*.*.debit' )->sum( function ( $sum ) {
                    return collect( $sum )->sum();
                } );
            }
        } else if ( $branch_id !== null && $current_class_id === null && $section_id === null ) { // if branch is selected
            $show_class_stats = true;

            for ( $i = 0; $i < count( $classes ); $i++ ) {
                $class_students = $students->where( 'current_class_id', $classes[$i]->id );

                // for calculating arrears for a class
                $classes[$i]->arrear = $class_students->pluck( 'feeArrears.*.arrear' )->sum( function ( $sum ) {
                    return collect( $sum )->sum();
                } );

                $for_credit_debit = $class_students->pluck( 'feeTransactions.*.records' );

                // for calculating credit
                $classes[$i]->credit = $for_credit_debit->pluck( '*.*.credit' )->sum( function ( $sum ) {
                    return collect( $sum )->sum();
                } );

                // for calculating total debit
                $classes[$i]->debit = $for_credit_debit->pluck( '*.*.debit' )->sum( function ( $sum ) {
                    return collect( $sum )->sum();
                } );
            }
        } else if ( $branch_id !== null && $current_class_id !== null && $section_id === null ) { // if branch and class is given
            $show_section_stats = true;

            for ( $i = 0; $i < count( $sections ); $i++ ) {
                $section_students = $students->where( 'section_id', $sections[$i]->id );

                // for calculating arrears for a section
                $sections[$i]->arrear = $section_students->pluck( 'feeArrears.*.arrear' )->sum( function ( $sum ) {
                    return collect( $sum )->sum();
                } );

                $for_credit_debit = $section_students->pluck( 'feeTransactions.*.records' );

                // for calculating credit
                $sections[$i]->credit = $for_credit_debit->pluck( '*.*.credit' )->sum( function ( $sum ) {
                    return collect( $sum )->sum();
                } );

                // for calculating total debit
                $sections[$i]->debit = $for_credit_debit->pluck( '*.*.debit' )->sum( function ( $sum ) {
                    return collect( $sum )->sum();
                } );
            }
        }

        return [
            'show_branches_stats' => $show_branches_stats,
            'show_class_stats' => $show_class_stats,
            'show_section_stats' => $show_section_stats
        ];
    }

    public function deleteTransaction( StudentFeeTransaction $studentFeeTransaction )
    {
        try {
            DB::transaction( function () use ( $studentFeeTransaction ) {
                $studentFeeTransaction->load( ['records'] );

                // go through every transaction record
                foreach ( $studentFeeTransaction->records as $studentFeeTransactionRecord ) {
                    // reverts all the records and adjust arrear of that fee type for student

                    $studentFeeArrear = StudentFeeArrear::firstOrNew( [
                        'student_id' => $studentFeeTransaction->student_id,
                        'student_fee_type_id' => $studentFeeTransactionRecord->student_fee_type_id
                    ] );

                    // if arrear exists, means record was found
                    if ( isset( $studentFeeArrear->arrear ) ) {
                        // in liability account, debit decreases the balance.
                        // So if we want to revert the transaction, debit is added to the arrear
                        $studentFeeArrear->arrear += $studentFeeTransactionRecord->debit;
                        // in liability account, credit increases the balance.
                        // so if we want to revert the transaction, credit is removed from the arrear
                        $studentFeeArrear->arrear -= $studentFeeTransactionRecord->credit;

                        // remission is also like debit. It decreases the student's arrear balance in case student is given some remission.
                        // if we want to revert it, we'll add the remission amount to the arrear.
                        $studentFeeArrear->arrear += $studentFeeTransactionRecord->remission;
                    } else {
                        $studentFeeArrear->arrear = 0;
                    }
                    $studentFeeArrear->save();
                }

                // delete all the records
                $studentFeeTransaction->records()->delete();
                // delete the transaction
                $studentFeeTransaction->delete();
            } );

            return back()->with( 'msg', "Transaction was deleted successfully and the amounts were adjusted in the respective fee arrears." );
        } catch ( \Exception $e ) {
            Log::error( "Transaction cannot be deleted", ['msg' => $e->getMessage(), 'studentFeeTransaction' => $studentFeeTransaction] );
            return back()->with( 'err', "Transaction could not be deleted at this time, kindly try again." );
        }
    }
}
