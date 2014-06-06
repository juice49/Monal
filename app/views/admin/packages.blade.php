@extends('../dashboard')
@section('body-header')
	<h2 class="dashboard__subtitle">System</h2>
	<h1 class="dashboard__title">Packages</h1>
@stop
@section('body-content')

	@if ($messages)
		<div class="node__y--bottom">
			@if ($messages->has('success'))
				<div class="message_box message_box--wasabi">
					<span class="message_box__title">Woot!</span>
					<ul>
						@foreach($messages->all() as $message)
							<li>{{ $message }}</li>
						@endforeach
					</ul>
				</div>
			@else
				<div class="message_box message_box--tomato">
					<span class="message_box__title">Great Scott!</span>
					<ul>
						@foreach($messages->all() as $message)
							<li>{{ $message }}</li>
						@endforeach
					</ul>
				</div> 
			@endif
		</div>
	@endif

	@if (!$uninstalled_packages->isEmpty())
		<div class="wall__tiles">
			@foreach ($uninstalled_packages as $namespace => $package)
				<div class="tile">
					<div class="tile__content">
						<ul class="tile__properties">
							<li class="tile__property">
								<span class="tile__property__key">Name:</span>
								<span class="tile__property__value">{{ $package['name'] }}</span>
							</li>
						</ul>
						<div class="node__y--top align--right">
							{{ Form::open() }}
								{{ Form::hidden('package', $namespace) }}
								{{ Form::submit('Install', array('class' => 'button button--small button--wasabi')) }}
							{{ Form::close() }}
						</div>
					</div>
				</div>
			@endforeach
		</div>
	@endif
@stop
