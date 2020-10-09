@extends("layouts.blank")

@section("content")

    <div class="container">
        <div class="text-center">
            <div>
                <img style="max-height: 150px; max-width: 150px;" src="{{ asset('img/prime-foundation-logo.png') }}" alt="{{ config('app.name') }}">
            </div>

            <h1 style="font-weight: bold;">{{ config('app.name') }}</h1>

            <h2 style="text-decoration: underline;">Leave Certificate</h2>
        </div>

        <div class="row" style="margin-top: 30px;">
            <div class="col-sm-6">Reference: _____________________</div>

            <div class="col-sm-6 text-right">Dated: {{ $current_date->format('d-M-Y') }}</div>
        </div>

        <div style="margin-top: 30px;">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>PIN</th>
                        <td>{{ $student->pin }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $student->name }}</td>
                    </tr>
                    <tr>
                        <th>Father's Name</th>
                        <td>{{ $student->fatherRecord->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Date Of Birth (In Figures)</th>
                        <td>{{ ( !empty($student->dob) ? $student->dob->format('d-M-Y') : '' ) }}</td>
                    </tr>
                    <tr>
                        <th>Date Of Birth (In Words)</th>
                        <td>{{ $student->dob_words }}</td>
                    </tr>
                    <tr>
                        <th>Date Of Joining School</th>
                        <td>{{ !empty($student->date_of_admission) ? $student->date_of_admission->format('d-M-Y') : '' }}</td>
                    </tr>
                    <tr>
                        <th>Date Of Leaving School</th>
                        <td>{{ $date_of_leaving_school->format('d-M-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Class When Joined</th>
                        <td>{{ $student->classOfAdmission->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Class When Left</th>
                        <td>{{ $student->currentClass->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Behaviour</th>
                        <td>{{ $conduct }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-justify" style="margin-top: 30px;"><b>Remarks:</b> {{ $remarks }}</div>

        <div class="row" style="margin-top: 70px;">
            <div class="col-xs-6">Office Stamp: ________________________________</div>

            <div class="col-xs-6 text-right">Principal: ________________________________</div>
        </div>
    </div>

@endsection
