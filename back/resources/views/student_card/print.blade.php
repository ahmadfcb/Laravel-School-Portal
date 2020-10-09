@extends("layouts.blank")

@section("content")

    <div class="student_card_print">
        @foreach($students as $student)
            <div class="student_card_container">
                <div class="student_card_inner_container">
                    <h3 class="student_card_heading">{{ config('app.name') }}</h3>

                    <div class="student_card_row">
                        <div class="student_card_left">
                            <img class="student_card_img" src="{{ Storage::url($student->image) }}" alt="{{ $student->name }}">
                        </div>

                        <div class="student_card_right">
                            <div><b>PIN:</b> <span style="font-size: 105%; font-weight: bold; text-decoration: underline;">{{ $student->pin }}</span></div>
                            <div><b>Name:</b> {{ $student->name }}</div>
                            <div><b>Father's Name:</b> {{ $student->fatherRecord->name ?? '' }}</div>
                            <div><b>CNIC:</b> {{ $student->cnic }}</div>
                            <div><b>Branch:</b> {{ $student->branch->name ?? '' }}</div>
                            <div><b>Class:</b> {{ $student->currentClass->name ?? '' }}</div>
                            <div><b>Section:</b> {{ $student->section->name ?? '' }}</div>
                        </div>
                    </div>

                    <div class="student_card_footer">
                        <div class="student_card_footer_left">Print Date: {{ $print_date }}</div>

                        <div class="student_card_footer_right">Principal's Sig. : _________________ </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection