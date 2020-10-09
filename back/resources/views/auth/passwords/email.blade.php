@extends("layouts.login")

@section("form")
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('password.email') }}" id="login-form" class="smart-form client-form" method="post">
        <header>
            Reset Password
        </header>

        {{ csrf_field() }}

        <fieldset>

            <section>
                <label class="label">E-mail</label>
                <label class="input"> <i class="icon-append fa fa-user"></i>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter email address/username</b>
                </label>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </section>

        </fieldset>
        <footer>
            <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
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
                    }
                },

                // Messages for form validation
                messages: {
                    email: {
                        required: 'Please enter your email address',
                        email: 'Please enter a VALID email address'
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
