@extends('../dashboard')
@section('body-header')
	<h2 class="dashboard__subtitle">Dashboard</h2>
	<h1 class="dashboard__title">Welcome {{ $system_user->first_name }}</h1>
@stop
@section('body-content')
	@if (!$uninstalled_packages->isEmpty())
		<div class="message_box message_box--mustard">
			<span class="message_box__title">Hey There!</span>
			<ul>
				<li>You have added packages to the system that require installation before they will work. <a href="{{ URL::route('admin.packages') }}">Click here to install them.</a></li>
			</ul>
		</div>
	@endif
@stop
