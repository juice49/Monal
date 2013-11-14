@extends('dashboard')

@section('head')
	<script src="http://localhost:8888/fructosecms.dev/app/modules/users/assets/users.js"></script>
@stop

@section('dashboard_content')
	<h1 class="dashboard-title">Manage Modules</h1>

	<div class="block alignright">
		<a href="" class="btn green">Install a new module</a>
	</div>

	@if($messages)
		@if($messages->has('success'))
			<div class="messagebox success">
				<h6>SUCCESS</h6>
				{{ $messages->get('success')[0] }}
			</div> 
		@endif
	@endif

	<h2 class="well-title">Add-on Modules</h2>
	<div class="well">
	</div>

	<h2 class="well-title">Core Modules</h2>
	<div class="well">
		<ul class="clearfix table_list">
			<li class="clearfix table_list-header">
				<div class="span-left span-20"><div class="span-pad">Name</div></div>
				<div class="span-left span-20"><div class="span-pad">Slug</div></div>
				<div class="span-left span-60"><div class="span-pad">Description</div></div>
			</li>
			<?php $i = 0 ?>
			@foreach($modules as $module)
				<?php $class = ($i % 2 == 0) ? 'odd' : 'even'; ?>
				<li class="clearfix {{ $class }}">
					<div class="span-left span-20"><div class="span-pad">{{ $module['details']['name'] }}</div></div>
					<div class="span-left span-20"><div class="span-pad">{{ $module['slug'] }}</div></div>
					<div class="span-left span-60"><div class="span-pad">{{ $module['details']['description']['en'] }}</div></div>
				</li>
				<?php $i++; ?>
			@endforeach
		</ul>
	</div>
@stop

@section('dashboard_config')
<div class="dashboard-config">

	<div class="dashboard-config-padd">
		
	</div>

</div>
@stop