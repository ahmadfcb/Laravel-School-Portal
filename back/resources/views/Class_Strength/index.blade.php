@extends("layouts.main")
@include("layouts.partials.datatable")

@section("content")
<div class="widget-body">

                        <form action="{{ url()->current() }}" method="get">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Branch</label>
                                        <select class="form-control branch" name="branch_id">
                                            <option value="">Select Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ $branch->id == $branch_id ? 'selected':'' }}>{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                   <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                                <table class="table table-striped table-bordered table-hover dtable">
                              
                                <th>Class</th>
                             	
                                    <th class="text-center" colspan="{{ ( Auth::user()->userHasPrivilege(['student_edit'], false) ? 11 : 10 ) }}"> Total Students: {{ $students_count['boys'] }}, Male: {{ $students_count['male'] }}, Female: {{ $students_count['female'] }}</th>
                                 
                                </tbody>
                            </table>
                            

@stop