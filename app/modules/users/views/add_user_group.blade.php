@extends('dashboard')

@section('head')
	<script src="http://localhost:8888/fructosecms.dev/app/modules/users/assets/usergroups.js"></script>
@stop

@section('dashboard_content')
	<h1 class="dashboard-title">Add User Group</h1>

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
		<h2 class="well-title">Group Details</h2>
		<div class="well">
			<div class="block">
				{{ Form::label('name', 'Name', array('class' => 'defaultlabel')) }}
				{{ Form::input('text', 'name', Input::has('name') ? Input::get('name') : null, array('class' => 'defaultinput')) }}
			</div>
			<div class="block">
				{{ Form::label('active', 'Activate', array('class' => 'defaultlabel')) }}
				{{ Form::checkbox('active', '1', Input::has('active') ? true : false) }}
			</div>
		</div>

		<h2 class="well-title">Group Privileges</h2>
		<div class="well">
			<h3 class="large_title">CMS Privileges</h3>
			<div class="subwell">
				<div class="block divider-bottom-dark">
					{{ Form::checkbox('cms', '1', Input::has('cms') ? true : null, array('id' => 'cms')) }}
					{{ Form::label('cms', 'Has CMS access', array('class' => 'inlinelabel')) }}
				</div>

				<div class="module_privileges">
					<h4 class="small_title divider-bottom-light">Module Access</h4>
					@foreach($modules as $module)
						@if($module['details']['has_backend'])
							<div class="block divider-bottom-light">
								{{ Form::checkbox('module_' . $module['slug'], $module['id'], Input::has('module_' . $module['slug']) ? true : false, array('id' => 'module_' . $module['slug'])) }}
								{{ Form::label('module_' . $module['slug'], $module['details']['name'], array('class' => 'inlinelabel')) }}
							</div>
						@endif
					@endforeach
				</div>
			</div>

			<h3 class="large_title">Front End Privileges</h3>
			<div class="subwell">
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