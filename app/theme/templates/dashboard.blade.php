<!DOCTYPE html>
<html lang="en">

	<head>
		@include('partials.head')
	</head>

	<body class="admin dashboard">

		<div class="control_panel">
			@yield('control_panel')
		</div>

		<div class="body-wrap">

			<div class="body">

				<div class="logout alignright">
					{{ Form::open() }}
						{{ Form::submit('Logout', array('name' => 'logout', 'class' => 'btn green')) }}
					{{ Form::close() }}
				</div>

				@yield('dashboard')
			</div>

		</div>

	</body>

</html>