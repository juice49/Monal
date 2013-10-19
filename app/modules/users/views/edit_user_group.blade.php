@extends('dashboard')

@section('dashboard_content')
	<h1 class="dashboard-title">Edit User Group</h1>

	@if($messages)
		<div class="messagebox error">
			<h6>ERROR</h6>
			<ul>
				@foreach($messages->all() as $message)
					<li>{{ $message }}</li>
				@endforeach
			</ul>
		</div> 
	@endif

	{{ Form::open() }}
		<div class="well">
			<div class="block">
				{{ Form::label('name', 'Name', array('class' => 'defaultlabel')) }}
				{{ Form::input('text', 'name', Input::has('name') ? Input::get('name') : $user_group['name'], array('class' => 'defaultinput')) }}
			</div>
			<div class="block">
				{{ Form::label('active', 'Activate', array('class' => 'defaultlabel')) }}
				{{ Form::checkbox('active', '1', Input::has('active') ? true : $user_group['active']) }}
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