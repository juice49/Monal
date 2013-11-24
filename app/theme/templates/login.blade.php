<!DOCTYPE html>
<html lang="en">

	<head>
		@include('partials.head')
		<link type="text/css" rel="stylesheet" href="http://localhost:8888/fructosecms.dev/app/theme/css/login.css" />
		<script src="http://localhost:8888/fructosecms.dev/app/theme/js/login.js"></script>
	</head>

	<body class="admin login">

		<div class="body-wrap">

			<div class="body">

				<div class="login-wrap">

					<div class="login-form-wrap">

						{{ Form::open(array('class' => 'login-form')) }}

							@if($messages)
								<div class="messagebox error">
									{{ $messages->get('error')[0] }}
								</div> 
							@endif

							{{ Form::label('email', 'Email', array('class' => 'loginlabel')) }}
							{{ Form::input('email', 'email', isset($input['email']) ? $input['email'] : '' , array('class' => 'logininput')) }}
							{{ Form::label('password', 'Password', array('class' => 'loginlabel')) }}
							{{ Form::input('password', 'password', null, array('class' => 'logininput')) }}
							<div class="alignright"> 
								{{ Form::submit('Login', array('class' => 'btn green')) }}
							</div>
						{{ Form::close() }}

					</div>

				</div>

			</div>

		</div>

	</body>

</html>