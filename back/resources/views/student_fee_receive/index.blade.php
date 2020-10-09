@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>{{ $title }}</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-money"></i>
    {{ $title }}
@endsection

@include("layouts.partials.datatable")

@section("content")
<!-- TOP 2 TABLES CODE -->
<div class="totaldues">
    <?php 
        $sum=0;
        $i=0;
        $j=0;
        $Fee=0;
        $Others=0;
        foreach ($feeTypes as $feeType) {
            $sum+=$feeType->studentFeeArrears[0]->arrear;
        }
 foreach ($feeTypes as $feeType) {
             $i++;
           $Fee= $feeType->studentFeeArrears[0]->arrear;
            if($i==1)
                {break;}
        }
 foreach ($feeTypes as $feeType) {
             $j++;
           $feeType->studentFeeArrears[0]->arrear;
            if($j==2)
        { $Others=$feeType->studentFeeArrears[0]->arrear;
            break;
        }
        }


        
          ?>   
  <fieldset>
    <table id="t02">
        <tr>
            <th>Payable Fee</th>
            <td style="width: 30%"><font color="red">{{$payableFee}}</font></td>
        </tr>
    </table>
    <br>
      <table id="t01" style="width: 32%">

           <tr>
    <th>Fee Arrear</th>
    <th>Others</th>
    <th>Total</th>
  </tr>
  <tr>
    <td>{{$Fee}}</td>
    <td>{{$Others}}</td>
    <td><font color="red">{{$sum}}</font></td>
  </tr>
      </table>
      <style>
          #t02 th, #t02 td {
  border: 1px solid black;
  border-collapse: collapse;
}

#t02 th, td {
     text-align: center;
  padding: 15px;
}
#t02 th{
     background-color: white;
  color: black;
    font-size: 18px;

}
#t02 td{
    font-size: 15px;
}
#t02 th{
    padding-left: :  15px;
}
      </style>

    <style>
#t01 th, #t01 td {
  border: 1px solid black;
  border-collapse: collapse;
}

#t01 th, td {
     text-align: center;
  padding: 5px;
}
#t01 th{
     background-color: white;
    font-size: 18px;

}
#t01 td{
    font-size: 15px;
}
</style>
    <!--   <h1>Total due balance is : {{ $sum }} </h1> -->
    
       
</div>
<br>
<!--........................-->

    <div class="row">
        <div class="col-xs-12" style="margin-bottom: 10px;">
            <a href="{{ $redirectUrl }}" class="btn btn-default">
                <i class="fa fa-arrow-left"></i>
                Back
            </a>
        </div>

        <article class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <!-- Widget ID (each widget will need unique ID)-->
          <div class="jarviswidget" id="wid-id-0">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-money"></i> </span>
                        <h2>Receive Fee </h2>

                    </header>

                    <!-- widget div-->
                    <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                        <input class="form-control" type="text">
                    </div>

                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body">
                        <form class="confirm_resubmission" action="{{ route('dashboard.student_fee.receive_fee', ['student' => $student->id]) }}" method="post">
                            {{ csrf_field() }}

                            <fieldset>
                                @foreach($feeTypes as $feeType)
                                    <input type="hidden" name="fee_types[{{ $loop->index }}][fee_type_id]" value="{{ $feeType->id }}">

                                    <div class="form-group">
                                        <label>{{ $feeType->name }} <small>(Arrear/Balance: {{ $feeType->studentFeeArrears[0]->arrear ?? 0 }})</small></label>
                                        <input type="text" class="form-control" name="fee_types[{{ $loop->index }}][value]" value="{{ old("fee_types[{$loop->iteration}][value]") }}" min="0" placeholder="{{ $feeType->name }}">
                                    </div>
                                @endforeach
                            </fieldset>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" name="btn_name" value="save">Save</button>
                                <button type="submit" class="btn btn-primary" name="btn_name" value="print">Save and Print</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>

        @if( \Auth::user()->userHasPrivilege('student_fee_remission') )
            <article class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-money"></i> </span>
                        <h2>Fee Remission </h2>

                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->
                            <input class="form-control" type="text">
                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">
                            <form class="confirm_resubmission" action="{{ route('dashboard.student_fee.fee_remission', ['student' => $student->id]) }}" method="post">
                                {{ csrf_field() }}

                                <fieldset>
                                    @foreach($feeTypes as $feeType)
                                        <input type="hidden" name="fee_types[{{ $loop->index }}][fee_type_id]" value="{{ $feeType->id }}">

                                        <div class="form-group">
                                            <label>{{ $feeType->name }} <small>(Arrear/Balance: {{ $feeType->studentFeeArrears[0]->arrear ?? 0 }})</small></label>
                                            <input type="text" class="form-control" name="fee_types[{{ $loop->index }}][remission_amount]" value="{{ old("fee_types[{$loop->iteration}][remission_amount]") }}" min="0" placeholder="{{ $feeType->name }} Remission" {!! ( isset($feeType->studentFeeArrears[0]->arrear) && intval($feeType->studentFeeArrears[0]->arrear) > 0 ? '' : 'readonly title="Fee remission not available for fee which are already paid in advance"' ) !!} rel="tooltip">
                                        </div>
                                    @endforeach
                                </fieldset>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Save Remission</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        @endif

        <article class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1">

                <header>
                    <span class="widget-icon"> <i class="fa fa-money"></i> </span>
                    <h2>User Details </h2>

                </header>

                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                        <input class="form-control" type="text">
                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body">

                        @if(!empty($student->image))
                            <div class="text-center" style="margin-bottom: 10px;">
                                <img src="{{ Storage::url($student->image) }}" style="max-height: 100px; max-width: 100px;">
                            </div>
                        @endif

                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Pin</th>
                                    <td>{{ $student->pin }}</td>
                                </tr>

                                <tr>
                                    <th>Reg#</th>
                                    <td>{{ $student->reg_no }}</td>
                                </tr>

                                <tr>
                                    <th>Name</th>
                                    <td>{{ $student->name }}</td>
                                </tr>

                                <tr>
                                    <th>Branch</th>
                                    <td>{{ $student->branch->name ?? "N/A" }}</td>
                                </tr>

                                <tr>
                                    <th>Class</th>
                                    <td>{{ $student->currentClass->name ?? "N/A" }}</td>
                                </tr>

                                <tr>
                                    <th>Section</th>
                                    <td>{{ $student->section->name ?? "N/A" }}</td>
                                </tr>

                                <tr>
                                    <th>Payable Student's<br>Monthly Fee</th>
                                    <th style="text-align:center" class="text-danger">{{ $payableFee }}</th>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </article>

        <div class="clearfix"></div>

        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-2">

                <header>
                    <span class="widget-icon"> <i class="fa fa-money"></i> </span>
                    <h2>Transactions </h2>

                </header>


                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                        <input class="form-control" type="text">
                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dtable">
                                <thead>
                                    <tr>
                                        <th>Datetime</th>
                                        <th>Transaction<br>Description</th>
                                        <th></th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>


<!DOCTYPE html>
<html>
<form action="" method="post">
<button type="button" name="">Fee generation</button>
</form>


                                    @foreach($studentFeeTransactions as $studentFeeTransaction)
                                        <tr>
                                        
                                            <td style="vertical-align: middle;">
                                                @if( Auth::user()->userHasPrivilege('student_fee_transaction_view_single') )
                                                    <a href="{{ route('dashboard.student_fee.transaction', ['studentFeeTransaction' => $studentFeeTransaction->id]) }}" title="Click to open transaction print page" rel="tooltip">
                                                        {{ $studentFeeTransaction->created_at->toDayDateTimeString() }} 
                                                    </a>
                                                @else
                                                    {{ $studentFeeTransaction->created_at->toDayDateTimeString() }}
                                                @endif
                                            </td>
                                     <td>{{  $studentFeeTransaction->description ?? '' }}</td>
                                            <td style="padding: 0;">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Fee Type</th>
                                                            <th>Received</th>
                                                            <th>Added to Student Account</th>
                                                            <th>Remission</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($studentFeeTransaction->records as $studentFeeTransactionRecord)
                                                            <tr>
                                                                <td>{{ $studentFeeTransactionRecord->studentFeeType->name ?? '' }}</td>
                                                                <td>{{ $studentFeeTransactionRecord->debit }}</td>
                                                                <td>{{ $studentFeeTransactionRecord->credit }}</td>
                                                                <td>{{ $studentFeeTransactionRecord->remission }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td class="vertical_align_middle text-center">
                                                @if( Auth::user()->userHasPrivilege('student_fee_transaction_delete'))
                                                    <a href="{{ route('dashboard.student_fee.transaction.delete', ['studentFeeTransaction' => $studentFeeTransaction->id]) }}" class="btn btn-danger btn-xs delete-confirm-model" title="Delete this transaction" rel="tooltip">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                @endif
                                               
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>

    <div class="text-center">
        <p>All transactions can be printed from this page. To print individual transaction details, click on the <i>date time</i> of the respective transaction.</p>
    </div>
</html>
@endsection