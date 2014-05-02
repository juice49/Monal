@extends('master')
@section('master-body')
	<div class="js--dashboard__menu dashboard__menu__wrap">
		<div class="dashboard__logo">
		</div>
		<ul class="dashboard__menu">
			@if (!empty($control_panel))
				@foreach ($control_panel as $group_title => $group_page)
					<li class="js--dashboard__menu__group dashboard__menu__group"><span class="dashboard__menu__group--title">{{ $group_title }}</span>
						<ul class="dashboard__menu__group--list">
							@foreach($group_page as $page_name => $page_route)
								<li class="dashboard__menu__group--item"><a href="{{ URL::to(Config::get('admin.slug') . '/' . $page_route) }}" class="dashboard__menu__group--link">{{ $page_name }}</a></li>
							@endforeach
						</ul>
					</li>
				@endforeach
			@endif
		</ul>
		<div class="dashboard__menu--group_bkg"></div>
	</div>
	<div class="js--dashboard__body dashboard__body">
		<div class="body__main__content">
			<section class="body__header">
				<span class="js--toggle_menu toggle_menu icon icon-menu"></span>
				<div class="button__dropdown__hover button--teal profile">
					<span class="button__dropdown__btn">{{ $system_user->first_name }} <i class="button__icon--right icon icon-arrow-down"></i></span>
					<div class="button__dropdown__container">
						<ul class="button__dropdown__list">
							<li>
								<form action="{{ URL::route('admin.logout') }}" method="post">
									<input type="submit" name="logout" value="Logout" class="dropdown__list__button" />
								</form>
							</li>
						</ul>
					</div>
				</div>
			</section>
			<section class="body__main__content__wrap">
				<header class="dashboard__header">
					@yield('body-header')
				</header>
				<div class="body__content">
					@yield('body-content')
				</div>
			</section>
		</div>
		<footer class="body__footer">
			<p>&copy; 2013, Reveal Legion</p>
		</footer>
	</div>
@stop