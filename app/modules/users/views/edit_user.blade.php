@extends('dashboard')

@section('head')
	<script src="http://localhost:8888/fructosecms.dev/app/modules/users/assets/users.js"></script>
	<script>
		var
			_USER_GROUP = {{ $user['group']['id'] }},
			_USER_GROUP_ACTIVE = {{ $user['group']['active'] }};
	</script>
@stop

@section('dashboard_content')
	<h1 class="dashboard-title">Edit User</h1>

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

	{{ Form::open(array('id' => 'user-form')) }}
		<?php $is_user = ($user['id'] == $current_user['id']) ? 'true' : 'false'; ?>
		<div class="well" data-user="{{ $is_user }}">
			<div class="block">
				{{ Form::label('first_name', 'First Name', array('class' => 'defaultlabel')) }}
				{{ Form::input('text', 'first_name', Input::has('first_name') ? Input::get('first_name') : $user['first_name'], array('class' => 'defaultinput')) }}
			</div>
			<div class="block">
				{{ Form::label('last_name', 'Last Name', array('class' => 'defaultlabel')) }}
				{{ Form::input('text', 'last_name', Input::has('last_name') ? Input::get('last_name') : $user['last_name'], array('class' => 'defaultinput')) }}
			</div>
			<div class="block">
				{{ Form::label('username', 'Username', array('class' => 'defaultlabel')) }}
				{{ Form::input('text', 'username', Input::has('username') ? Input::get('username') : $user['username'], array('class' => 'defaultinput')) }}
			</div>
			<div class="block">
				{{ Form::label('email', 'Email Address', array('class' => 'defaultlabel')) }}
				{{ Form::input('email', 'email', Input::has('email') ? Input::get('email') : $user['email'], array('class' => 'defaultinput')) }}
			</div>
			<div class="block">
				{{ Form::label('password', 'Password', array('class' => 'defaultlabel')) }}
				{{ Form::input('password', 'password', null, array('class' => 'defaultinput')) }}
			</div>
			<div class="block">
				{{ Form::label('password_confirmation', 'Confirm Password', array('class' => 'defaultlabel')) }}
				{{ Form::input('password', 'password_confirmation', null, array('class' => 'defaultinput')) }}
			</div>
			<div class="block">
				{{ Form::label('user_group', 'User Group', array('class' => 'defaultlabel')) }}
				{{ Form::select('user_group', $user_groups, Input::has('user_group') ? Input::get('user_group') : $user['group']['id'], array('class' => 'defaultselect')) }}
			</div>
			<div class="block">
				{{ Form::label('active', 'Activate', array('class' => 'defaultlabel')) }}
				{{ Form::checkbox('active', '1', Input::has('active') ? true : $user['active']) }}
			</div>
		</div>

		<div class="clearfix block">
			<div class="span-left span-50">
				<a href="{{ URL::route('admin.users') }}" class="btn orange">Cancel</a>
			</div>
			<div class="span-right spand-50 alignright">
				{{ Form::submit('Save', array('class' => 'btn green')) }}
			</div>
		</div>
	{{ Form::close() }}
@stop