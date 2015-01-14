<!-- Title Form Input -->
<div class="form-group {{ hasError('title', $errors) }}">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', Input::get('title', $post->title), ['class' => 'form-control', 'placeholder' => '']) !!}
</div>
<!-- Url Form Input -->
<div class="form-group {{ hasError('url', $errors) }}">
    {!! Form::label('url', 'Url:') !!}
    {!! Form::url('url', Input::get('url', $post->url), ['class' => 'form-control', 'placeholder' => '']) !!}
</div>
<div class="form-group">
    <strong>or</strong>
</div>
<!-- Text Form Input -->
<div class="form-group {{ hasError('text', $errors) }}">
    {!! Form::label('text', 'Text:') !!}
    {!! Form::textarea('text', Input::get('text', $post->text), ['class' => 'form-control', 'placeholder' => '']) !!}
</div>