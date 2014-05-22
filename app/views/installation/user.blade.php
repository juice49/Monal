@extends('master')
@section('master-body')
	<div class="installation__wrap">
		<h1 class="color--teal fs--bravo">Installation Guide</h1>
		<p class="color--grey__medium fs--echo">Welcome. This guide will take you through 3 simple steps to install the Monal core system and get you up and running in a jiffy!</p>

		@if ($messages)
			<div class="message_box message_box--tomato">
				<span class="message_box__title">Great Scott!</span>
				<ul>
					@foreach($messages->all() as $message)
						<li>{{ $message }}</li>
					@endforeach
				</ul>
			</div> 
		@endif

		<div class="well">
			<h2><span class="color--grey__vlight">Step 2:</span> Create User Account</h2>
			{{ Form::open() }}
				<div class="control_block"> 
					{{ Form::label('first_name', 'First Name', array('class' => 'label label--block')) }}
					{{ Form::input('text', 'first_name', Input::has('first_name') ? Input::get('first_name') : null, array('class' => 'input__text')) }}
				</div>
				<div class="control_block"> 
					{{ Form::label('last_name', 'Last Name', array('class' => 'label label--block')) }}
					{{ Form::input('text', 'last_name', Input::has('last_name') ? Input::get('last_name') : null, array('class' => 'input__text')) }}
				</div>
				<div class="control_block"> 
					{{ Form::label('username', 'Username', array('class' => 'label label--block')) }}
					{{ Form::input('text', 'username', Input::has('username') ? Input::get('username') : null, array('class' => 'input__text')) }}
				</div>
				<div class="control_block"> 
					{{ Form::label('email', 'Email Address', array('class' => 'label label--block')) }}
					{{ Form::input('text', 'email', Input::has('email') ? Input::get('email') : null, array('class' => 'input__text')) }}
				</div>
				<div class="control_block"> 
					{{ Form::label('password', 'Password', array('class' => 'label label--block')) }}
					{{ Form::input('password', 'password', Input::has('password') ? Input::get('password') : null, array('class' => 'input__text')) }}
				</div>
				<div class="control_block"> 
					{{ Form::label('password_confirmation', 'Confirm Password', array('class' => 'label label--block')) }}
					{{ Form::input('password', 'password_confirmation', Input::has('password_confirmation') ? Input::get('password_confirmation') : null, array('class' => 'input__text')) }}
				</div>
				<div class="control_block">
					{{ Form::submit('Next Step', array('class' => 'button button--teal')) }}
				</div>
			{{ Form::close() }}
		</div>
	</div>
	<div class="dashboard__footer">
		<span>&copy; 2013, Reveal Legion</span>
	</div>
@stop