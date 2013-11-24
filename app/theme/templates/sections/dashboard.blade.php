@extends('dashboard')

@section('dashboard_content')
	<h1 class="dashboard-title">Welcome {{ $user->first_name }}</h1>
@stop