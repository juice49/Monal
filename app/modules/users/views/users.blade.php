@extends('dashboard')

@section('dashboard_content')
	<h1 class="dashboard-title">Manage Users</h1>

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
			<li class="clearfix {{ $class }}">
				<div class="span-left span-20"><div class="span-pad">{{ $user['first_name'] . ' ' . $user['last_name'] }}</div></div>
				<div class="span-left span-20"><div class="span-pad">{{ $user['username'] }}</div></div>
				<div class="span-left span-20"><div class="span-pad">{{ $user['group']['name'] }}</div></div>
				@if($user['active'])
					<div class="span-left span-10 aligncenter"><div class="span-pad"><span class="btn green small">yes</span></div></div>
				@else
					<div class="span-left span-10 aligncenter"><div class="span-pad">No</div></div>
				@endif
				<div class="span-left span-30 alignright"><div class="span-pad"><span class="btn blue small">edit</span><span class="btn red small">delete</span></div></div>
			</li>
			<?php $i++; ?>
		@endforeach
		</ul>
	</div>
@stop