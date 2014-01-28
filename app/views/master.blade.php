<!DOCTYPE>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" href="{{ URL::to('admin/build/fonts/style.css') }}" media="screen">
		<link rel="stylesheet" type="text/css" href="{{ URL::to('admin/build/css/fruitful.css') }}" media="screen">

		<script src="{{ URL::to('admin/build/js/libs/jquery-1.10.2.js') }}"></script>
		<script src="{{ URL::to('admin/build/js/libs/jquery.conscious.js') }}"></script>
		<script>
			var _APP_BASEURL = '{{ URL::to('/') }}/';
		</script>
		@yield('master-head')
	</head>
	<body>
		<div class="body">
			@yield('master-body')
		</div>
	</body>
</html>