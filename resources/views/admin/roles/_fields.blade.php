{{-- Only show these on the edit page --}}
@if( routeNameIsNot('admin.roles.create') )
    {{-- If role account was deleted then offer a way to restore the record. --}}
    @if( $role->trashed())
        <div class="label label-danger">This role is deleted.</div>
        <div class="form-group {!! hasError('restore', $errors) !!}">
            <label>
                {!! Form::checkbox('restore', 1, Input::get('restore', false)) !!}
                Yes, I would like to <strong class="underlined">restore</strong> this record.
            </label>
        </div>
    @else
    {{-- Offer a way for the role account to be deleted. --}}
        <div class="label label-success">This role is live.</div>
        <div class="form-group {!! hasError('delete', $errors) !!}">
            <label>
                {!! Form::checkbox('delete', 1, Input::get('delete', false)) !!}
                Yes, I would like to <strong class="underlined">delete</strong> this record.
            </label>
    @endif
    <hr/>
@endif
<!-- Core Form Input -->
<div class="form-group {{ hasError('core', $errors) }}">
    {!! Form::label('core', 'Core Role:') !!}
    {!! Form::select('core', [0 => 'No', 1 => 'Yes'], Input::get('core', $role->core), ['class' => 'form-control', 'placeholder' => '']) !!}
</div>
<!-- Username Form Input -->
<div class="form-group {{ hasError('name', $errors) }}">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', Input::get('name', $role->name), ['class' => 'form-control']) !!}
</div>