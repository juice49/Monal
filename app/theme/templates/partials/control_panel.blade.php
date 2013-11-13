<nav class="control_panel-nav">

	<ul class="control_panel-headings">
		@foreach($control_panel as $menu_heading => $submenu)
			@if(empty($submenu))
				<li class="control_panel-heading" data-submenu="null" data-active="false"><span>{{ $menu_heading }}</span></li>
			@else
				<li class="control_panel-heading" data-submenu="cp-{{ Str::slug(strtolower($menu_heading)) }}" data-active="false"><span>{{ $menu_heading }}</span>
					<ul class="control_panel-submenu" id="cp-{{ Str::slug($menu_heading) }}">
						@foreach($submenu as $page_name => $page_route)
							<li><a href="{{ URL::to('/admin' . $page_route) }}">{{ $page_name }}</a></li>
						@endforeach
					</ul>
				</li>
			@endif
		@endforeach
	</ul>

</nav>