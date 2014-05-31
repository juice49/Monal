@extends('master')
@section('master-body')
	<div class="js--control_panel dashboard__control_panel">
		<div class="dashboard__logo">
			<img src="{{ URL::to('system_theme/images/logo.png') }}" alt="Monal" />
		</div>
		<ul class="dashboard__menu">
			<li class="dashboard__menu__group"><a href="{{ URL::route('admin.dashboard') }}" class="menu__group__title">Dashboard</a>
			@if (!empty($control_panel))
				@foreach ($control_panel as $group_title => $group_page)
					<li class="dashboard__menu__group"><span class="js--menu__option menu__group__title">{{ $group_title }}</span>
						<ul class="js--menu__options menu__group__options">
							@foreach($group_page as $page_name => $page_route)
								<li class="menu__group__option">
									<a href="{{ URL::to(Config::get('admin.slug') . '/' . $page_route) }}" class="menu__group__link">{{ $page_name }}</a>
								</li>
							@endforeach
						</ul>
					</li>
				@endforeach
			@endif
		</ul>
	</div>
	<div class="dashboard__wrap">
		<div class="dashboard__body__wrap">
			<div class="dashboard__mobile__nav">
				<span class="js--mobile__nav icon icon-menu"></span>
			</div>
			<div class="js--dashboard__header dashboard__header">
				<div class="dashboard__user">
					<div class="js--dashboard__user dashboard__user__details">
						<span class="icon icon-user"></span>
						<span class="dashboard__header__name">{{ $system_user->first_name }}</span>
						<span class="icon icon-triangle-down"></span>
					</div>
					<ul class="js--user__menu dashboard__user__menu">
						<li><a href="{{ URL::route('admin.logout') }}">Logout</a></li>
					</ul>
				</div>
				@yield('body-header')
			</div>
			<div class="dashboard__body">
				@yield('body-content')
			</div>
		</div>
		<div class="dashboard__footer">
			<span>&copy; 2013, Reveal Legion</span>
		</div>
	</div>
@stop