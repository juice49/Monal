@extends('../basic')

@section('body-header')
	<h1 class="color--teal">Installation Guide</h1>
	<p class="fs--echo">Welcome. This guide will take you through 3 simple steps to install the Monal core system and get you up and running in a jiffy!</p>
@stop

@section('body-content')

	@if ($messages)
		<div class="message_box message_box--tomato">
			<h6>Great Scott!</h6>
			<ul>
				@foreach($messages->all() as $message)
					<li>{{ $message }}</li>
				@endforeach
			</ul>
		</div> 
	@endif

	<section class="well">
		<h2><span class="color--grey__vlight">Step 3:</span> Remove Installation Files</h2>
		{{ Form::open() }}
			<p>Almost there! We have configured everything successfully and the last thing left to do is to delete the installation files, as leaving them present poses a security risk. The following directories should be deleted:</p>
			<ul>
				<li>/app/installation</li>
				<li>/app/views/installation</li>
			</ul>
			<p>You can do this manually or we can do this for you:</p>
			{{ Form::input('submit', 'remove', 'Remove Installation Files', array('class' => 'button button--teal')) }}
		{{ Form::close() }}
	</section>
@stop