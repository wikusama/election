<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
	<link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name') }}</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

	<!--     Fonts and icons     -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

	<!-- CSS Files -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/material-kit.css') }}" rel="stylesheet"/>
	
	@yield('after_style')

</head>

<body class="landing-page">
    @include('layout.navigation')

    <div class="wrapper">
        <div class="header header-filter" style="background-image: url('{{ $bg_header??asset('img/header/smk2.png') }}');">
            <div class="container">
                <div class="row">
					<div class="col-md-6">
						<h1 class="title">Widyaloka Kusuma Samekta Makarya</h1>
	                    <h4>It's the time to make new regulation on this awesome organization. Who will be next? Take your time and coffee before decide to vote!</h4>
					</div>
                </div>
            </div>
        </div>

		<div class="main main-raised">
			<div class="container">

	        	@yield('content')
				
	        </div>

		</div>

	    <footer class="footer">
	        <div class="container">
	            <nav class="pull-left">
	                <ul>
	                    <li>
	                        <a href="https://www.facebook.com/groups/wikusama/" target="_blank">
	                            <span class="fa fa-facebook-square"></span> Wikusama on Facebook
	                        </a>
	                    </li>
	                </ul>
	            </nav>
	            <div class="copyright pull-right">
	                &copy; {{ date('Y') }}, made with <i class="fa fa-heart heart"></i> for Wikusama
	            </div>
	        </div>
	    </footer>

	</div>
</body>

	<!--   Core JS Files   -->
	<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/material.min.js') }}"></script>

	<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
	<script src="{{ asset('js/nouislider.min.js') }}" type="text/javascript"></script>

	<!--  Plugin for the Datepicker, full documentation here: http://www.eyecon.ro/bootstrap-datepicker/ -->
	<script src="{{ asset('js/bootstrap-datepicker.js') }}" type="text/javascript"></script>

	<!-- Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc -->
	<script src="{{ asset('js/material-kit.js') }}" type="text/javascript"></script>

	@yield('after_script')

</html>
