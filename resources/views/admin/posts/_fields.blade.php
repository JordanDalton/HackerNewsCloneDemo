{{-- If post account was deleted then offer a way to restore the record. --}}
@if( $post->trashed())
    <div class="label label-danger">This post has been deleted.</div>
    <div class="form-group {!! hasError('restore', $errors) !!}">
        <label>
            {!! Form::checkbox('restore', 1, Input::get('restore', false)) !!}
            Yes, I would like to <strong class="underlined">restore</strong> this record.
        </label>
    </div>
@else
{{-- Offer a way for the post account to be deleted. --}}
    <div class="label label-success">This post is in good standing.</div>
    <div class="form-group {!! hasError('delete', $errors) !!}">
        <label>
            {!! Form::checkbox('delete', 1, Input::get('delete', false)) !!}
            Yes, I would like to <strong class="underlined">delete</strong> this record.
        </label>
@endif
<hr/>
<!-- Title Form Input -->
<div class="form-group {{ hasError('title', $errors) }}">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', Input::get('title', $post->title), ['class' => 'form-control', 'placeholder' => '']) !!}
</div>
<!-- Url Form Input -->
<div class="form-group {{ hasError('url', $errors) }}">
    {!! Form::label('url', 'URL:') !!}
    {!! Form::text('url', Input::get('url', $post->url), ['class' => 'form-control', 'placeholder' => '']) !!}
</div>
<!-- Text Form Input -->
<div class="form-group {{ hasError('text', $errors) }}">
    {!! Form::label('text', 'Text:') !!}
    {!! Form::textarea('text', Input::get('text', $post->text), ['class' => 'form-control', 'rows' => 3]) !!}
</div>
<hr/>