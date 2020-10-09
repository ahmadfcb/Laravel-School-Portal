@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
@endsection

@section("content")
    <h2>Quick links</h2>

    @if(empty($availableButtons))
        <p><a href={{ url('/dashboard/student/admission') }} class="btn btn-block btn-default">Admission</a>
		<a href={{ url('/dashboard/student') }} class="btn btn-block btn-default">Student</a> 
		<a href={{ url('/dashboard/attendance-sheet') }} class="btn btn-block btn-default">Student Attendance Sheet</a> 
		<a href={{ url('/dashboard/student-fee/receive-fee/mass') }} class="btn btn-block btn-default">Fee Receive With PIN</a> 
		</p>
    @else
        <div class="row">
            @foreach($availableButtons as $availableButton)
                <div class="col-sm-3" style="margin-bottom: 15px;">
                    <a href="{{ $availableButton['link'] }}" class="btn btn-block btn-default">{{ $availableButton['text'] }}</a>
                </div>
            @endforeach
        </div>
    @endif
@endsection