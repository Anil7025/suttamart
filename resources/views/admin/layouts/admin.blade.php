<!doctype html>
<html lang="">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	@php $gtext = gtext();  @endphp
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title') | {{ $gtext['site_title'] }}</title>
	<!-- favicon -->
	<link rel="shortcut icon" href="{{ $gtext['favicon'] ? asset('media/'.$gtext['favicon']) : asset('admin/images/favicon.ico') }}" type="image/x-icon">
	<link rel="icon" href="{{ $gtext['favicon'] ? asset('media/'.$gtext['favicon']) : asset('admin/images/favicon.ico') }}" type="image/x-icon">
    <!-- CSS -->
	<style type="text/css">
	:root {
	  --admin-theme-color: {{ $gtext['theme_color'] }};
	}
	</style>
    <link rel="stylesheet" href="{{asset('admin/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/chosen/bootstrap-chosen.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/jquery.gritter.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/responsive.css')}}">
	@stack('style')
  </head>
  <body>
	<div id="wrapper" class="d-flex relative">
		<!-- Sidebar -->
		@include('admin.partials.sidebar')
		<!-- /Sidebar/ -->
		<!-- Page Content -->
		<div id="page-content-wrapper">
			<!--Top Navbar-->
			@include('admin.partials.topnav')
			<!--/Top Navbar/-->
			<!--Main Body-->
			@yield('content')	
			<!--/Main Body/-->
		</div><!-- /Page Content/ -->
	</div><!--/wrapper-->
    <!-- JS -->
	<script src="{{asset('admin/js/jquery-3.6.0.min.js')}}"></script>
	<script src="{{asset('admin/js/popper.min.js')}}"></script>
	<script src="{{asset('admin/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('admin/js/jquery-ui.min.js')}}"></script>
	<script src="{{asset('admin/js/jquery.nicescroll.min.js')}}"></script>
	<script src="{{asset('admin/js/parsley.min.js')}}"></script>
	<script src="{{asset('admin/js/chosen.jquery.min.js')}}"></script>
	<script src="{{asset('admin/js/jquery.popupoverlay.min.js')}}"></script>
	<script src="{{asset('admin/js/jquery.gritter.min.js')}}"></script>
	<script type="text/javascript">
	var base_url = "{{ url('/') }}";
	var public_path = "{{ asset('public') }}";
	var userid = "{{ Auth::user()->id }}";
	</script>
	<script src="{{asset('admin/js/script.js')}}"></script>
	<div class="custom-popup light width-100 dnone" id="lightCustomModal">
		<div class="padding-md">
			<h4 class="m-top-none">{{ __('This is alert message') }}</h4>
		</div>
		<div class="text-center">
			<a href="javascript:void(0);" class="btn blue-btn lightCustomModal_close mr-10" onClick="onConfirm()">{{ __('Confirm') }}</a>
			<a href="javascript:void(0);" class="btn danger-btn lightCustomModal_close">{{ __('Cancel') }}</a>
		</div>
	</div>
	<a href="#lightCustomModal" class="btn btn-warning btn-small lightCustomModal_open dnone">{{ __('Edit') }}</a>
	@stack('scripts')
  </body>
</html>