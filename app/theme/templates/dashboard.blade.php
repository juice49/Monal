<!DOCTYPE html>
<html lang="en">

	<head>
		@include('partials.head')
	</head>

	<body class="admin dashboard">

		<div class="control_panel">
			<div class="logo">
			</div>
			@include('partials.control_panel')
			<div class="control_panel-submenu_bkg">
				<span class="control_panel_close"></span>
			</div>
		</div>

		<div class="body-wrap">

			<div class="body">

				<div class="logout alignright">
					{{ Form::open() }}
						{{ Form::submit('Logout', array('name' => 'logout', 'class' => 'btn green')) }}
					{{ Form::close() }}
				</div>

				<div class="dashboard-main">
					
					<div class="dashboard-content">
						@yield('dashboard_content')
					</div>

					@yield('dashboard_config')

				</div>

			</div>

		</div>

	</body>

</html>