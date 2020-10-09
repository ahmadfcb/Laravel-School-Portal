@extends("layouts.blank")

@section("content")

    <div class="text-center" style="font-size: 1.2em; margin-bottom: 10px;"><b>Branch:</b> {{ $branch->name }}, <b>Class:</b> {{ $current_class->name }}, <b>Section:</b> {{ $section->name }}</div>

    @if($students->isEmpty())
        <p class="text-center text-danger">No student found!</p>
    @else
        <div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>PIN</th>
                        <th>Sr</th>
                        <th>Name</th>

                        @foreach($print_sheet_columns as $print_sheet_column)
                            <th>{{ $print_sheet_column->name }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $student->pin }}</td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $student->name }}</td>

                            @for($i=0; $i < count($print_sheet_columns); $i++)
                                <td></td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="small text-right">Printed on {{ $printDate->format('d-M-Y') }} at {{ $printDate->format('g:i:s A') }}</div>
    @endif

@endsection