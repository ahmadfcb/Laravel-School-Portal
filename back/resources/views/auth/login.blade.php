@extends("layouts.login")

@section("form")
    <form action="{{ route('login') }}" id="login-form" class="smart-form client-form" method="post">
        {{ csrf_field() }}

        <header>
            Sign In
        </header>

        <fieldset>

            <section>
                <label class="label">E-mail</label>
                <label class="input"> <i class="icon-append fa fa-user"></i>
                    <input type="email" name="email" autofocus="autofocus">
                    <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter email address</b>
                </label>

                @if ($errors->has('email'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </section>

            <section>
                <label class="label">Password</label>
                <label class="input"> <i class="icon-append fa fa-lock"></i>
                    <input type="password" name="password">
                    <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your password</b>
                </label>
                <div class="note">
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                </div>

                @if ($errors->has('password'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </section>

            <section>
                <label class="checkbox">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <i></i>Stay signed in
                </label>
            </section>
        </fieldset>
        <footer>
            <button type="submit" class="btn btn-primary">Sign in</button>
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
                        minlength: 6,
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
