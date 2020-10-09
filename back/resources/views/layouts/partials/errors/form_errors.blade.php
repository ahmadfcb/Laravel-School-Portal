@if ($errors->any())
    <script>
        @foreach ($errors->all() as $error)
            jQuery( function () {
                jQuery.smallBox( {
                    title: "ERROR",
                    content: "{!! $error !!}",
                    color: "#c46b6a",
                    timeout: 10000,
                    icon: "fa fa-warning"
                } );
            } );
        @endforeach
    </script>
@endif

{{--@if ($errors->any())--}}
    {{--<div>--}}
        {{--<div class="alert alert-danger alert-dismissible" role="alert" style="display: inline-block;">--}}
            {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
                {{--<span aria-hidden="true">&times;</span>--}}
            {{--</button>--}}
            {{--<ul>--}}
                {{--@foreach ($errors->all() as $error)--}}
                    {{--<li>{{ $error }}</li>--}}
                {{--@endforeach--}}
            {{--</ul>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endif--}}
