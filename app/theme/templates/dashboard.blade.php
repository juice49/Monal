<!DOCTYPE html>
<html lang="en">

	<head>
		@include('partials.head')
		@yield('head')
	</head>

	<body class="admin dashboard">

		<div class="control_panel">
			<div class="logo">
			</div>
			@include('partials.control_panel')

			<div class="control_panel-shadow_left"><div></div></div>
			<div class="control_panel-shadow_right"></div>

			<div class="control_panel-submenu_bkg">
				<div class="control_panel-submenu_bkg-border"></div>
				<div class="control_panel-submenu_close"><span class="icon icon-close"></span></div>
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