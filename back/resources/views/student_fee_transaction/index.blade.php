@extends("layouts.blank")

@section("content")

    <div class="student_fee_transaction_print">
        <div class="student_fee_transaction_print_single">
            <div class="" style="font-size: 80%">
            </div>
            <h3 class="student_fee_transaction_print_single_heading">Fee Transaction Details</h3>
            <table class="table" style="">
                <tbody>
                    <tr>
                        <th>PIN</th>
                        <td>{{ $studentFeeTransaction->student->pin }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $studentFeeTransaction->student->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Father's Name</th>
                        <td>{{ $studentFeeTransaction->student->fatherRecord->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Branch</th>
                        <td>{{ $studentFeeTransaction->student->branch->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Class</th>
                        <td>{{ $studentFeeTransaction->student->currentClass->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Section</th>
                        <td>{{ $studentFeeTransaction->student->section->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $studentFeeTransaction->student->category->name ?? '' }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Fee</th>
                        <th>Added to account <small>(Rs.)</small></th>
                        <th>Paid <small>(Rs.)</small></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($studentFeeTransaction->records as $studentFeeTransactionRecord)
                        <tr>
                            <td>{{ $studentFeeTransactionRecord->studentFeeType->name ?? '' }}</td>
                            <td>{{ $studentFeeTransactionRecord->credit ?? 0 }}</td>
                            <td>{{ $studentFeeTransactionRecord->debit ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <th>{{ $studentFeeTransaction->records->sum('credit') ?? 0 }}</th>
                        <th>{{ $studentFeeTransaction->records->sum('debit') ?? 0 }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

@endsection