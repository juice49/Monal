@extends('../dashboard')
@section('body-header')
	<h2 class="dashboard__subtitle">Dashboard</h2>
	<h1 class="dashboard__title">Welcome {{ $system_user->first_name }}</h1>
@stop