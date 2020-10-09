@extends("layouts.blank")

@section("content")

    <div class="container">
        <div class="text-center">
            <div>
                <img style="max-height: 150px; max-width: 150px;" src="{{ asset('img/prime-foundation-logo.png') }}" alt="{{ config('app.name') }}">
            </div>

            <h1 style="font-weight: bold;">{{ config('app.name') }}</h1>

            <h2 style="text-decoration: underline;">Character Certificate</h2>
        </div>

        <div class="text-justify" style="margin-top: 70px;">
            <p>This is to clarify that <b>{{ $student->name }}</b> {{ ( $student->gender == 'male' ? 'S/O' : 'D/O' ) }} <b>{{ $student->fatherRecord->name ?? '' }}</b> has been a bonafide student of this school of class <b>{{ $student->currentClass->name ?? '' }}</b>. His date of birth according to the school record is {{ (!empty($student->dob) ? $student->dob->format('d-M-Y') : '') }}.</p>
            <p>He has been <b>{{ $conduct }}</b> student. I wish {{ ( $student->gender == '' ? 'him' : 'her' ) }} success in life.</p>
        </div>

        <div class="text-left" style="margin-top: 30px;">
            <b>Remarks:</b> {{ $remarks }}
        </div>
        
        <div class="row" style="margin-top: 90px;">
            <div class="col-xs-6">Dated: {{ $date->toDayDateTimeString() }}</div>

            <div class="col-xs-6 text-right">Signature: ______________________________</div>
        </div>
    </div>

@endsection
