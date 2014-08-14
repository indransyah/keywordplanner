<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="author" content="">

		<!-- MAIN CSS -->
		{{ HTML::style('assets/css/bootstrap.min.css') }}
		{{ HTML::style('assets/css/ndoboost.css') }}

		<!-- PLUGINS CSS -->
		{{ HTML::style('assets/plugins/font-awesome/css/font-awesome.css') }}
		{{ HTML::style('assets/plugins/weather-icon/css/weather-icons.css') }}
		{{ HTML::style('assets/plugins/prettify/prettify.css') }}
		{{ HTML::style('assets/plugins/magnific-popup/magnific-popup.css') }}
		{{ HTML::style('assets/plugins/owl-carousel/owl.carousel.css') }}
		{{ HTML::style('assets/plugins/owl-carousel/owl.theme.css') }}
		{{ HTML::style('assets/plugins/owl-carousel/owl.transitions.css') }}
        <title>Keyword Planner - Google AdWords Keyword Planner</title>
        <link href='http://fonts.googleapis.com/css?family=Lato:400,700,900' rel='stylesheet' type='text/css'>
        {{ HTML::style('assets/css/dashboard.css') }}
    </head>
    <body id="top" class="tooltips" style="background-color: #F5F7FA;">
        @include('layouts.navbar')
        <div class="page-wrapping">
            @include('layouts.sidebar')
            <div class="content-page">
                <div class="content-page-inner">
                    <div class="container-fluid">
                        @yield('content')
                    </div><!-- /.container-fluid" -->
                </div><!-- /.content-page-inner -->
            </div><!-- /.content-page -->
        </div><!-- /.page-wrapping -->
        @include('layouts.footer')
    </body>
</html>