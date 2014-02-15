@extends('../basic')

@section('body-header')
	<h1 class="color--teal">Installation Guide</h1>
	<p class="fs--echo">Welcome. This guide will take you through 3 simple steps to install the Fruitful core system and get you up and running in a jiffy!</p>
@stop

@section('body-content')

	@if ($messages)
		<div class="message_box message_box--tomato">
			<h6>Great Scott!</h6>
			<ul>
				@foreach($messages->all() as $message)
					<li>{{ $message }}</li>
				@endforeach
			</ul>
		</div> 
	@endif

	<section class="well">
		<h2><span class="color--grey__vlight">Step 1:</span> Configure Database</h2>
		{{ Form::open() }}
			<div class="control_block">
				{{ Form::label('dbms', 'Database Management System', array('class' => 'label--block')) }}
				<div class="select__default"> 
				{{ Form::select('dbms', $database_management_systems, Input::has('dbms') ? Input::get('dbms') : 'mysql', array('class' => 'select')) }}
				</div>
			</div>
			<div class="control_block"> 
				{{ Form::label('host', 'Host Name', array('class' => 'label--block')) }}
				{{ Form::label('host', 'This is the host name where your database is stored. If the database is on the same server that hosts this website then this can usually be left as "localhost"', array('class' => 'label--block label--description')) }}
				{{ Form::input('text', 'host', Input::has('host') ? Input::get('host') : 'localhost', array('class' => 'input--text')) }}
			</div>
			<div class="control_block">
				{{ Form::label('database', 'Database Name', array('class' => 'label--block')) }}
				{{ Form::input('text', 'database', Input::has('database') ? Input::get('database') : null, array('class' => 'input--text')) }}
			</div>
			<div class="control_block">
				{{ Form::label('username', 'Username', array('class' => 'label--block')) }}
				{{ Form::input('text', 'username', Input::has('username') ? Input::get('username') : null, array('class' => 'input--text')) }}
			</div>
			<div class="control_block">
				{{ Form::label('password', 'Password', array('class' => 'label--block')) }}
				{{ Form::input('password', 'password', Input::has('password') ? Input::get('password') : null, array('class' => 'input--text')) }}
			</div>
			<div class="control_block">
				{{ Form::label('port', 'Port', array('class' => 'label--block')) }}
				{{ Form::input('number', 'port', Input::has('port') ? Input::get('port') : 3306, array('class' => 'input--number__default')) }}
			</div>
			<div class="control_block">
				{{ Form::label('create', 'Create Database', array('class' => 'label--block')) }}
				{{ Form::label('create', 'Should we try to create the database for you, or have you already created it?', array('class' => 'label--block label--description')) }}
				{{ Form::checkbox('create', 'create', Input::has('create') ? true : false, array('class' => 'input--checkbox')) }}
				<label for="create" class="input--checkbox__default"></label>
			</div>
			<div class="control_block">
				{{ Form::submit('Next Step', array('class' => 'button button--teal')) }}
			</div>
		{{ Form::close() }}
	</section>
@stop