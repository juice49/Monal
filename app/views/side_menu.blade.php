@extends('master')

@section('master-body')
	<div class="body__menu">
	</div>
	<div class="body__sidemenu">
		<div class="body__main__content">
			<header class="body__header">
				@yield('body-header')
			</header>
			<div class="body__content">
				@yield('body-content')
			</div>
		</div>
		<footer class="body__footer">
			<p>Copyright &copy; 2013 Fruitful Digital LTD</p>
		</footer>
	</div>
@stop