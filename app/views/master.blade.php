<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no_js lt-ie10 lt-ie9 lt-ie8 lt-ie7">
<![endif]-->
<!--[if IE 7]>
<html class="no_js lt-ie10 lt-ie9 lt-ie8">
<![endif]-->
<!--[if IE 8]>
<html class="no_js lt-ie10 lt-ie9">
<![endif]-->
<!--[if IE 9]>
<html class="no_js lt-ie10">
<![endif]-->
<!--[if gt IE 9]><!-->
<html class="no_js">
<!--<![endif]-->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" href="{{ URL::to('admin/build/app.css') }}" media="screen">
		@foreach ($system->dashboard->css() as $css)
			<link rel="stylesheet" type="text/css" href="{{ $css }}" media="screen">
		@endforeach
		<script>
			var _APP_BASEURL = '{{ URL::to('/') }}/';
		</script>
		<script src="{{ URL::to('admin/components/jquery-1.11.0/index.js') }}"></script>
		<script src="{{ URL::to('admin/build/app.js') }}"></script>
		@foreach ($system->dashboard->scripts() as $script)
			<script src="{{ $script }}"></script>
		@endforeach
		@yield('master-head')
	</head>
	<body>
		<div class="js--dashboard dashboard">
			@yield('master-body')
		</div>
	</body>
</html>