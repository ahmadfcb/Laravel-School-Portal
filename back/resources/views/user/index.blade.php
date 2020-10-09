@extends("layouts.main")

@section("page_header")
    <li class="fa fa-fw fa-home"></li> Dashboard
@endsection
@section("page_subtitle", "Users")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>Users</li>
@endsection

@include('layouts.partials.datatable')

@section("content")
    <div class="row">

        @if(Auth::user()->userHasPrivilege('account_user_add'))
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-5 col-md-4 col-lg-4">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0">
                    <!-- widget options:
                        usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                        data-widget-colorbutton="false"
                        data-widget-editbutton="false"
                        data-widget-togglebutton="false"
                        data-widget-deletebutton="false"
                        data-widget-fullscreenbutton="false"
                        data-widget-custombutton="false"
                        data-widget-collapsed="true"
                        data-widget-sortable="false"

                    -->
                    <header>
                        <span class="widget-icon"> <i class="fa fa-user"></i> </span>
                        <h2>{{ ($editUser->id === null ? 'Add User' : 'Update User') }} </h2>

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

                            <form action="{{ route('dashboard.users') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                @if($editUser->id !== null)
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="user_id" value="{{ $editUser->id }}">
                                @endif

                                <fieldset>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') ?? $editUser->name ?? '' }}" placeholder="Name">
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email') ?? $editUser->email ?? '' }}" placeholder="Email">
                                    </div>

                                    <div class="form-group">
                                        <label>Picture</label>
                                        <div>
                                            <img class="img-responsive" style="max-height: 100px;" id="img_preview" src="{{ Storage::url( $editUser->image ?? 'user_images/avatars/male.png' ) }}" alt="User image">
                                        </div>
                                        <input class="show-image-preview" data-target="#img_preview" type="file" name="image">
                                    </div>

                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select name="gender" class="form-control">
                                            <option value="male" {{ old('gender', ( $editUser->gender ?? '' ) ) == 'male' ? 'selected="selected"' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', ( $editUser->gender ?? '' ) ) == 'female' ? 'selected="selected"' : '' }}>Female</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password">
                                    </div>
                                </fieldset>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        {{ ( $editUser->id === null ? 'Create User Account' : 'Update User Account' ) }}
                                    </button>
                                </div>
                            </form>

                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->

            </article>
            <!-- WIDGET END -->
        @endif

        <article class="col-xs-12 col-sm-7 col-md-8 col-lg-8">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1">

                <header>
                    <span class="widget-icon"> <i class="fa fa-users"></i> </span>
                    <h2>Users </h2>

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
                            <table class="table table-striped table-bordered table-hover dtable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ ucfirst($user->gender) }}</td>
                                            <td>
                                                <img style="max-width: 50px; max-height: 50px;" src="{{ Storage::url($user->image) }}" alt="{{ $user->name }}">
                                            </td>
                                            <td>
                                                <a href="{{ route('dashboard.users', ['editUser' => $user->id]) }}" class="btn btn-default btn-xs" rel="tooltip" title="Edit User's Account">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                @if(Auth::user()->userHasPrivilege('account_user_privilege'))
                                                    <a class="btn btn-default btn-xs" href="{{ route('dashboard.users.privilege', ['user' => $user->id]) }}" rel="tooltip" title="User Privileges">
                                                        <i class="fa fa-shield"></i>
                                                    </a>
                                                @endif

                                                @if(Auth::user()->userHasPrivilege('account_user_delete'))
                                                    <a class="btn btn-default btn-xs delete-confirm-model" href="{{ route('dashboard.users.delete', ['user' => $user->id]) }}" title="Delete User" rel="tooltip">
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->

            </div>
            <!-- end widget -->

        </article>

    </div>
@endsection
