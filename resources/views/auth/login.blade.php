@extends($layout)

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">Login</div>
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

                    {!! Form::open(['class' => 'form-horizontal', 'role' => 'form', 'route' => 'auth.login']) !!}
                        <!-- Email Form Input -->
                        <div class="form-group {{ hasError('email', $errors) }}">
                            {!! Form::label('email', 'Email:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('email', Input::get('email', ''), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <!-- Password Form Input -->
                        <div class="form-group {{ hasError('password', $errors) }}">
                            {!! Form::label('password', 'Password:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <!-- Remember User Form Input -->
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
                                        {!! Form::checkbox('remember', 1, Input::get('remember', false)) !!} Remember Me
									</label>
								</div>
							</div>
						</div>
                        <!-- Submit Form Button -->
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
                                {!! Form::button('Login', ['class' => 'btn btn-primary', 'style' => 'margin-right: 15px', 'type' => 'submit']) !!}
								<a href="{{ route('auth.password') }}">Forgot Your Password?</a>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
