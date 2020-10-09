<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ ( !empty( $title ) ? $title . " - " : "" ) }}{{ config('app.name') }}</title>

        <link href="{{ asset("ap/css/bootstrap.min.css") }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset("ap/css/font-awesome.min.css") }}">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset("css/custom_styles.css") }}">

        @stack("css")
    </head>
    <body id="site_blank_pages">

        @if( isset($showPrintButtons) && $showPrintButtons === true )
            <div class="blank_button_container hidden-print">
                <button class="btn btn-default" onclick="window.history.back()"><i class="fa fa-chevron-left"></i> Back</button>
                <button class="btn btn-primary" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
            </div>
        @endif

        @yield("content")

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="{{ asset('ap/js/bootstrap/bootstrap.min.js') }}"></script>

        @stack("js")
    </body>
</html>