<!DOCTYPE>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" href="{{ URL::to('admin/build/fonts/style.css') }}" media="screen">
		<link rel="stylesheet" type="text/css" href="{{ URL::to('admin/build/css/monal.css') }}" media="screen">
		<link rel="stylesheet" type="text/css" href="{{ URL::to('admin//js/libs/freshalert/css/styles.css') }}" media="screen">
		<link rel="stylesheet" type="text/css" href="{{ URL::to('packages/monal/data/js/redactor/redactor.css') }}" />

		<script src="{{ URL::to('admin/build/js/monal.js') }}"></script>
		<script src="{{ URL::to('packages/monal/data/js/redactor/redactor.min.js') }}"></script>
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