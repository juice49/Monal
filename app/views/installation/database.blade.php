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
			<h2><span class="color--grey__vlight">Step 1:</span> Configure Database</h2>
			{{ Form::open() }}
				<div class="control_block">
					{{ Form::label('dbms', 'Database Management System', array('class' => 'label label--block')) }}
					{{ Form::select('dbms', $database_management_systems, Input::has('dbms') ? Input::get('dbms') : 'mysql', array('class' => 'select')) }}
				</div>
				<div class="control_block"> 
					{{ Form::label('host', 'Host Name', array('class' => 'label label--block')) }}
					{{ Form::label('host', 'This is the host name where your database is stored. If the database is on the same server that hosts this website then this can usually be left as "localhost"', array('class' => 'label label--block label--description')) }}
					{{ Form::input('text', 'host', Input::has('host') ? Input::get('host') : 'localhost', array('class' => 'input__text')) }}
				</div>
				<div class="control_block">
					{{ Form::label('database', 'Database Name', array('class' => 'label label--block')) }}
					{{ Form::input('text', 'database', Input::has('database') ? Input::get('database') : null, array('class' => 'input__text')) }}
				</div>
				<div class="control_block">
					{{ Form::label('username', 'Username', array('class' => 'label label--block')) }}
					{{ Form::input('text', 'username', Input::has('username') ? Input::get('username') : null, array('class' => 'input__text')) }}
				</div>
				<div class="control_block">
					{{ Form::label('password', 'Password', array('class' => 'label label--block')) }}
					{{ Form::input('password', 'password', Input::has('password') ? Input::get('password') : null, array('class' => 'input__text')) }}
				</div>
				<div class="control_block">
					{{ Form::label('port', 'Port', array('class' => 'label label--block')) }}
					{{ Form::input('number', 'port', Input::has('port') ? Input::get('port') : 3306, array('class' => 'input__number')) }}
				</div>
				<div class="control_block">
					{{ Form::label('create', 'Create Database', array('class' => 'label label--block')) }}
					{{ Form::label('create', 'Should we try to create the database for you, or have you already created it?', array('class' => 'label label--block label--description')) }}
					<label for="create" class="checkbox">
						{{ Form::checkbox('create', 'create', Input::has('create') ? true : false, array('class' => 'checkbox__input')) }}
					</label>
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