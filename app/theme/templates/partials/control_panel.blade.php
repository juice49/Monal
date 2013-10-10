<nav class="control_panel-nav">

	<ul>
		@foreach($modules as $name => $submenu)
			@if(empty($submenu))
				<li class="cp-heading" data-submenu="false"><a href="{{ URL::to('/admin/' . strtolower($name)) }}">{{ $name }}</a></li>
			@else
				<li class="cp-heading has_submenu" data-submenu="cp-{{ Str::slug(strtolower($name)) }}"><span>{{ $name }}</span>
					<ul class="cp-submenu" id="cp-{{ Str::slug($name) }}">
						@foreach($submenu as $page_name => $page_route)
							<li><a href="{{ '/admin' . $page_route }}">{{ $page_name }}</a></li>
						@endforeach
					</ul>
				</li>
			@endif
		@endforeach
	</ul>

</nav>