{{-- If comment account was deleted then offer a way to restore the record. --}}
@if( $comment->trashed())
    <div class="label label-danger">This comment has been deleted.</div>
    <div class="form-group {!! hasError('restore', $errors) !!}">
        <label>
            {!! Form::checkbox('restore', 1, Input::get('restore', false)) !!}
            Yes, I would like to <strong class="underlined">restore</strong> this record.
        </label>
    </div>
@else
{{-- Offer a way for the comment account to be deleted. --}}
    <div class="label label-success">This comment is in good standing.</div>
    <div class="form-group {!! hasError('delete', $errors) !!}">
        <label>
            {!! Form::checkbox('delete', 1, Input::get('delete', false)) !!}
            Yes, I would like to <strong class="underlined">delete</strong> this record.
        </label>
@endif
<hr/>
<!-- Comment Form Input -->
<div class="form-group {{ hasError('comment', $errors) }}">
    {!! Form::label('comment', 'Tell Us About You:') !!}
    {!! Form::textarea('comment', Input::get('comment', $comment->comment), ['class' => 'form-control', 'rows' => 3]) !!}
</div>
<hr/>