@extends("layouts.main")

@section("breadcrumb")
    <li>Accounts</li>
    <li>Change Account Details</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-wrench"></i> Change User Account Details
@endsection

@section("content")
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-6 col-md-6 col-lg-4">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">
                <header>
                    <span class="widget-icon"> <i class="fa fa-user"></i> </span>
                    <h2>Basic Information </h2>

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

                        <form action="{{ route('dashboard.users.update_basic_info') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <fieldset>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" placeholder="Name">
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" placeholder="Email" disabled="disabled">
                                </div>

                                <div class="form-group">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control">
                                        <option value="male" {{ ( $user->gender == 'male' ? 'selected' : '' ) }}>Male</option>
                                        <option value="female" {{ ( $user->gender == 'female' ? 'selected' : '' ) }}>Female</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div class="">
                                        <img id="profile_image" class="img-responsive" src="{{ Storage::url($user->image) }}" alt="{{ $user->name }}">
                                    </div>
                                    <input type="file" name="image" accept=".jpg,.jpeg,.png" onchange="readAndShowImage(this, '#profile_image')">
                                </div>
                            </fieldset>

                            <div class="form-actions">
                                <button class="btn btn-primary" type="submit">Update</button>
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

        <article class="col-xs-12 col-sm-6 col-md-6 col-lg-4">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1">
                <header>
                    <span class="widget-icon"> <i class="fa fa-user"></i> </span>
                    <h2>Password </h2>

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
                        <form action="{{ route('dashboard.users.update_password') }}" method="post">
                            {{ csrf_field() }}

                            <fieldset>
                                <div class="form-group">
                                    <label>Old Password</label>
                                    <input type="password" class="form-control" name="old_password" value="" placeholder="Old Password">
                                </div>

                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" class="form-control" name="new_password" value="" placeholder="New Password">
                                </div>

                                <div class="form-group">
                                    <label>New Password Again</label>
                                    <input type="password" class="form-control" name="new_password_confirmation" value="" placeholder="New Password Again">
                                </div>
                            </fieldset>

                            <div class="form-actions">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>

    </div>
@endsection