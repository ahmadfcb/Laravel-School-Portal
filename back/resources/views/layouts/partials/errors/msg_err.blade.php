{{--For success messages--}}
@if( !empty( session('msg') ) )
    @if( is_array( session( 'msg' ) ) )
        @foreach(session('msg') as $msg)
            <script>
                jQuery( function () {
                    jQuery.smallBox( {
                        title: "SUCCESS",
                        content: "{!! $msg !!}",
                        color: "#749e74",
                        timeout: 10000,
                        icon: "fa fa-check"
                    } );
                } );
            </script>
        @endforeach
    @else
        <script>
            jQuery( function () {
                jQuery.smallBox( {
                    title: "SUCCESS",
                    content: "{!! session('msg') !!}",
                    color: "#749e74",
                    timeout: 10000,
                    icon: "fa fa-check"
                } );
            } );
        </script>
    @endif
@endif

{{--For error messages--}}
@if( !empty( session( 'err' ) ) )
    @if( is_array( session( 'err' ) ) )
        @foreach(session( 'err' ) as $err)
            <script>
                jQuery( function () {
                    jQuery.smallBox( {
                        title: "ERROR",
                        content: "{!! $err !!}",
                        color: "#c46b6a",
                        timeout: 10000,
                        icon: "fa fa-warning"
                    } );
                } );
            </script>
        @endforeach
    @else
        <script>
            jQuery( function () {
                jQuery.smallBox( {
                    title: "ERROR",
                    content: "{!! session('err') !!}",
                    color: "#c46b6a",
                    timeout: 10000,
                    icon: "fa fa-warning"
                } );
            } );
        </script>
    @endif
@endif

{{--@if(!empty(session('msg')))--}}
    {{--<div>--}}
        {{--<div class="alert alert-success alert-dismissible" role="alert" style="display: inline-block;">--}}
            {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
                {{--<span aria-hidden="true">&times;</span>--}}
            {{--</button>--}}

            {{--{{ session('msg') }}--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endif--}}

{{--@if(!empty(session('err')))--}}
    {{--<div>--}}
        {{--<div class="alert alert-danger alert-dismissible" role="alert" style="display: inline-block;">--}}
            {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
                {{--<span aria-hidden="true">&times;</span>--}}
            {{--</button>--}}

            {{--{{ session('err') }}--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endif--}}
