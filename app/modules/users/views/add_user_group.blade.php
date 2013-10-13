@extends('dashboard')

@section('dashboard_content')
	<h1 class="dashboard-title">Add User Group</h1>

	@if($messages->has('error'))
		<div class="messagebox error">
			{{ $messages->get('error')[0] }}
		</div> 
	@endif

	{{ Form::open() }}
		<div class="well">
			<div class="block">
				{{ Form::label('name', 'Name', array('class' => 'defaultlabel')) }}
				{{ Form::input('text', 'name', Input::has('name') ? Input::get('name') : null, array('class' => 'defaultinput')) }}
			</div>
			<div class="block">
				{{ Form::label('active', 'Make Active', array('class' => 'defaultlabel')) }}
				{{ Form::checkbox('active', '1', Input::has('active') ? true : false) }}
			</div>
		</div>

		<div class="clearfix block">
			<div class="span-left span-50">
				<a href="{{ URL::route('admin.users.groups') }}" class="btn orange">Cancel</a>
			</div>
			<div class="span-right spand-50 alignright">
				{{ Form::submit('Save', array('class' => 'btn green')) }}
			</div>
		</div>
	{{ Form::close() }}
@stop