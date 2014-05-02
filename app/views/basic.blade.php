@extends('master')

@section('master-body')
<div class="basic__body">
	<div class="body__main__content">
		<header class="body__header">
			@yield('body-header')
		</header>
		<div class="body__content">
			@yield('body-content')
		</div>
	</div>
	<footer class="body__footer">
		<p>&copy; 2013, Reveal Legion</p>
	</footer>
</div>
@stop