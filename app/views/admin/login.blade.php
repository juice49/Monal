@extends('../basic')

@section('body-content')
<div class="login__container">
	<div class="login__box">
		{{ Form::open() }}
			@if ($messages)
				<div class="message_box message_box--tomato">
					<ul>
						@foreach($messages->all() as $message)
							<li>{{ $message }}</li>
						@endforeach
					</ul>
				</div> 
			@endif
			<div class="block__y__bottom">
				{{ Form::label('email', 'Email', array('class' => 'label--block')) }}
				{{ Form::input('email', 'email', Input::has('email') ? Input::get('email') : null, array('class' => 'input--text')) }}
				{{ Form::label('password', 'Password', array('class' => 'label--block')) }}
				{{ Form::input('password', 'password', null, array('class' => 'input--text')) }}
			</div>
			<div class="block__y__top">
				{{ Form::submit('Sign In', array('class' => 'button button--turquoise')) }}
			</div>
		{{ Form::close() }}
	</div>
</div>
@stop