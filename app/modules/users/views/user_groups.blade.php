@extends('dashboard')

@section('head')
	<script src="http://localhost:8888/fructosecms.dev/app/modules/users/assets/usergroups.js"></script>
@stop

@section('dashboard_content')
	<h1 class="dashboard-title">Manage User Groups</h1>

	<div class="block alignright">
		<a href="{{ URL::route('admin.users.groups.add') }}" class="btn green">Add new user group</a>
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
				<div class="span-left span-45"><div class="span-pad">Name</div></div>
				<div class="span-left span-10 aligncenter"><div class="span-pad">Active</div></div>
				<div class="span-left span-45 alignright"><div class="span-pad">Actions</div></div>
			</li>
			<?php $i = 0 ?>
			@foreach($user_groups as $group)
				<?php $class = ($i % 2 == 0) ? 'odd' : 'even'; ?>
				<?php $is_user_group = ($group['id'] == $current_user->details['group']) ? true : false; ?>
				<li class="clearfix {{ $class }}">
					<div class="span-left span-45"><div class="span-pad">{{ $group['name'] }}</div></div>
					@if($group['id'] == 1)
						<div class="span-left span-10 aligncenter"><div class="span-pad">yes</div></div>
					@else
						@if($group['active'])
							<div class="span-left span-10 aligncenter"><div class="span-pad"><span class="btn green small active_state" data-id="{{ $group['id'] }}" data-state="active" data-user_group="{{ $is_user_group }}">yes</span></div></div>
						@else
							<div class="span-left span-10 aligncenter"><div class="span-pad"><span class="btn orange small active_state" data-id="{{ $group['id'] }}" data-state="inactive" data-user_group="{{ $is_user_group }}">no</span></div></div>
						@endif
					@endif
					<div class="span-left span-45 alignright"><div class="span-pad"><a href="{{ URL::route('admin.users.groups.edit', array('group_id' => $group['id'])) }}" class="btn blue small">edit</a><span class="btn red small">delete</span></div></div>
				</li>
				<?php $i++; ?>
			@endforeach
		</ul>
	</div>
@stop