@extends('master')
@section('master-body')
	<div class="login__container">
		<div class="login__box">
			{{ Form::open(array('class' => 'login__form')) }}
				@if ($messages)
					<div class="node__y--bottom">
						<div class="message_box message_box--tomato">
							<ul>
								@foreach($messages->all() as $message)
									<li>{{ $message }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif
				<div class="block__y__bottom">
					{{ Form::label('email', 'Email', array('class' => 'label label--block')) }}
					{{ Form::input('email', 'email', Input::has('email') ? Input::get('email') : null, array('class' => 'input__text')) }}
				</div>
				<div class="block__y__bottom"> 
					{{ Form::label('password', 'Password', array('class' => 'label label--block')) }}
					{{ Form::input('password', 'password', null, array('class' => 'input__text')) }}
				</div>
				<div>
					{{ Form::submit('Sign In', array('class' => 'button button--teal')) }}
					<label for="remember_me" class="label checkbox login__form__remember">
						<input type="checkbox" name="remember_me" value="1" {{ Input::has('remember_me') ? 'checked="checked"' : '' }} class="checkbox__input" id="remember_me"/>
						<span class="checkbox__label">Remember Me</span>
					</label>
				</div>
			{{ Form::close() }}
		</div>
	</div>
	<div class="dashboard__footer">
		<span>&copy; 2013, Reveal Legion</span>
	</div>
@stop