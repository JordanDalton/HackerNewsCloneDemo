{{-- If user account was deleted then offer a way to restore the record. --}}
@if( $user->trashed())
    <div class="label label-danger">This account has been deleted.</div>
    <div class="form-group {!! hasError('restore', $errors) !!}">
        <label>
            {!! Form::checkbox('restore', 1, Input::get('restore', false)) !!}
            Yes, I would like to <strong class="underlined">restore</strong> this record.
        </label>
    </div>
@else
{{-- Offer a way for the user account to be deleted. --}}
    <div class="label label-success">This account is in good standing.</div>
    <div class="form-group {!! hasError('delete', $errors) !!}">
        <label>
            {!! Form::checkbox('delete', 1, Input::get('delete', false)) !!}
            Yes, I would like to <strong class="underlined">delete</strong> this record.
        </label>
@endif
<hr/>
<!-- User Role Assignments -->
<div class="form-group {!! hasError('roles', $errors) !!}">
    {!! Form::label('roles', 'Select Role(s)', ['class' => 'control-label']) !!}
    {!! Form::select('roles[]', $roles, Input::get('roles', $assigned_role_ids), ['class' => 'form-control', 'multiple' => 'multiple']) !!}
</div>
<hr/>
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