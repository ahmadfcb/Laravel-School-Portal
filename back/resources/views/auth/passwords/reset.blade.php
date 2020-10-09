@extends("layouts.login")

@section("form")
    <form action="{{ route('password.request') }}" id="login-form" class="smart-form client-form" method="post">
        <header>
            Reset Password
        </header>

        {{ csrf_field() }}

        <input type="hidden" name="token" value="{{ $token }}">

        <fieldset>

            <section>
                <label class="label">E-mail</label>
                <label class="input"> <i class="icon-append fa fa-user"></i>
                    <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
                    <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter email address</b>
                </label>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </section>

            <section>
                <label class="label">Password</label>
                <label class="input"> <i class="icon-append fa fa-lock"></i>
                    <input id="password" type="password" class="form-control" name="password" required>
                    <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your password</b>
                </label>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif

            </section>

            <section>
                <label class="label">Confirm Password</label>
                <label class="input"> <i class="icon-append fa fa-lock"></i>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                    <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Password Confirmation</b>
                </label>

                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </section>
        </fieldset>
        <footer>
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </footer>
    </form>
@endsection

@push("body")
    <script type="text/javascript">
        $( function () {
            // Validation
            $( "#login-form" ).validate( {
                // Rules for form validation
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 6
                    }
                },

                // Messages for form validation
                messages: {
                    email: {
                        required: 'Please enter your email address',
                        email: 'Please enter a VALID email address'
                    },
                    password: {
                        required: 'Please enter your password'
                    },
                    password_confirmation: {
                        required: 'Please enter your password'
                    }
                },

                // Do not change code below
                errorPlacement: function ( error, element ) {
                    error.insertAfter( element.parent() );
                }
            } );
        } );
    </script>
@endpush
