<!-- Username Form Input -->
<div class="form-group {{ hasError('username', $errors) }}">
    {!! Form::label('username', 'Username:') !!}
    {!! Form::text('username', Input::get('username', $user->username), ['class' => 'form-control']) !!}
</div>
<!-- Email Form Input -->
<div class="form-group {{ hasError('email', $errors) }}">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', Input::get('email', $user->email), ['class' => 'form-control']) !!}
</div>
<!-- About Form Input -->
<div class="form-group {{ hasError('about', $errors) }}">
    {!! Form::label('about', 'Tell Us About You:') !!}
    {!! Form::textarea('about', Input::get('about', $user->about), ['class' => 'form-control', 'rows' => 3]) !!}
</div>
<hr/>
<h4>Change Password (Optional)</h4>
<!-- Password Form Input -->
<div class="form-group {{ hasError('password', $errors) }}">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>
<!-- Password Confirmation Form Input -->
<div class="form-group {{ hasError('password_confirmation', $errors) }}">
    {!! Form::label('password_confirmation', 'Re-Enter Password:') !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
</div>