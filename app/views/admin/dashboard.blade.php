@extends('../dashboard')
@section('master-head')
	<script src="{{ URL::to('admin/build/js/core.js') }}"></script>
@stop
@section('body-header')
	<h1 class="color--teal">Welcome {{ $system_user->first_name }}</h1>
@stop