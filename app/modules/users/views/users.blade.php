@extends('dashboard')

@section('head')
	<script src="http://localhost:8888/fructosecms.dev/app/modules/users/assets/users.js"></script>
@stop

@section('dashboard_content')
	<h1 class="dashboard-title">Manage Users</h1>

	<div class="block alignright">
		<a href="{{ URL::route('admin.users.add') }}" class="btn green">Add new user</a>
	</div>

	@if($messages)
		@if($messages->has('success'))
			<div class="messagebox success">
				<h6>SUCCESS</h6>
				{{ $messages->get('success')[0] }}
			</div> 
		@endif
	@endif

	<div class="well">
		<ul class="clearfix table_list">
			<li class="clearfix table_list-header">
				<div class="span-left span-20"><div class="span-pad">Name</div></div>
				<div class="span-left span-20"><div class="span-pad">Username</div></div>
				<div class="span-left span-20"><div class="span-pad">Group</div></div>
				<div class="span-left span-10 aligncenter"><div class="span-pad">Active</div></div>
				<div class="span-left span-30 alignright"><div class="span-pad">Actions</div></div>
			</li>
		<?php $i = 0 ?>
		@foreach($users as $user)
			<?php $class = ($i % 2 == 0) ? 'odd' : 'even'; ?>
			<?php $is_user = ($user['id'] == $current_user['id']) ? true : false; ?>
			<li class="clearfix {{ $class }}" id="row-{{ $i }}">
				<div class="span-left span-20"><div class="span-pad"><span class="false_txtbtn user-details" data-user_details="user_details-{{ $user['id'] }}" data-row="{{ $i }}">{{ $user['first_name'] . ' ' . $user['last_name'] }}</span></div></div>
				<div class="span-left span-20"><div class="span-pad">{{ $user['username'] }}</div></div>
				<div class="span-left span-20"><div class="span-pad">{{ $user['group']['name'] }}</div></div>
				@if($user['group']['active'])
					@if($user['active'])
						<div class="span-left span-10 aligncenter"><div class="span-pad"><span class="btn green small active_state" data-id="{{ $user['id'] }}" data-state="active" data-user="{{ $is_user }}">yes</span></div></div>
					@else
						<div class="span-left span-10 aligncenter"><div class="span-pad"><span class="btn orange small active_state" data-id="{{ $user['id'] }}" data-state="inactive" data-user="{{ $is_user }}">no</span></div></div>
					@endif
				@else
					<div class="span-left span-10 aligncenter"><div class="span-pad">no</div></div>
				@endif
				<div class="span-left span-30 alignright"><div class="span-pad"><a href="{{ URL::route('admin.users.edit', array('user_id' => $user['id'])) }}" class="btn blue small">edit</a><span class="btn red small">delete</span></div></div>
			</li>
			<?php $i++; ?>
		@endforeach
		</ul>
	</div>
@stop

@section('dashboard_config')
<div class="dashboard-config">

	<div class="dashboard-config-padd">
		<h2 class="dashboard-config-title">User Details</h2>
		@foreach($users as $user)
			<ul class="config_panel-nolist" id="user_details-{{ $user['id'] }}">
				<li><span class="config_panel-list_heading">ID</span>{{ $user['id'] }}</li>
				<li><span class="config_panel-list_heading">Last Logged In</span>Never</li>
				<li><span class="config_panel-list_heading">Last Updated</span>{{ $user['updated_at'] }}</li>
				<li><span class="config_panel-list_heading">Created</span>{{ $user['created_at'] }}</li>
			</ul>
		@endforeach
	</div>

</div>
@stop