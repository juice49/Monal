@extends('dashboard')

@section('head')
	<script src="http://localhost:8888/fructosecms.dev/app/modules/users/assets/usergroups.js"></script>
	<script>
		var
			_USER_GROUP = {{ $user_group['id'] }},
			_CURRENT_USER_GROUP = {{ $current_user['group'] }};
	</script>
@stop

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

	{{ Form::open(array('id' => 'user_group-form')) }}
		<div class="well">
			<div class="block">
				{{ Form::label('name', 'Name', array('class' => 'defaultlabel')) }}
				{{ Form::input('text', 'name', Input::has('name') ? Input::get('name') : $user_group['name'], array('class' => 'defaultinput')) }}
			</div>
			@if($user_group['id'] != 1)
				<div class="block">
					{{ Form::label('active', 'Activate', array('class' => 'defaultlabel')) }}
					{{ Form::checkbox('active', '1', Input::has('active') ? true : $user_group['active']) }}
				</div>
			@endif
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