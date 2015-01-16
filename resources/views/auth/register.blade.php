@extends($layout)

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">Register</div>
				<div class="panel-body">

					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

                    {!! Form::open(['class' => 'form-horizontal', 'role' => 'form', 'route' => 'auth.register']) !!}
                        <!-- Username Form Input -->
                        <div class="form-group {{ hasError('username', $errors) }}">
                            {!! Form::label('username', 'Username:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('username', Input::get('username', ''), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <!-- Email Form Input -->
                        <div class="form-group {{ hasError('email', $errors) }}">
                            {!! Form::label('email', 'Email:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::email('email', Input::get('email', ''), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <!-- Password Form Input -->
                        <div class="form-group {{ hasError('password', $errors) }}">
                            {!! Form::label('password', 'Password:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <!-- Password Confirmation Form Input -->
                        <div class="form-group {{ hasError('password_confirmation', $errors) }}">
                            {!! Form::label('password_confirmation', 'Confirm Password:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <!-- Submit Form Button -->
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::button('Register', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
                            </div>
                        </div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
