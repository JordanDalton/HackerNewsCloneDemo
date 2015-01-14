@extends('layouts.default')

@section('pageTitle')
    {{ $post->getTitle() }} | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">
            <div class="page-header">
                <h1><a href="{{ $post->getPostUrl() }}" target="_blank">{{ $post->getTitle() }}</a>
                    @if( $post->hasUrl() )
                        <small>({{ $post->getUrlDomain() }})</small>
                    @endif
                </h1>
                <p>768 points by <a class="underlined" href="{{ $post->getLinkToPostersProfile() }}">{{ $post->getUsernameOfPoster() }}</a> {{ $post->getDurationSinceCreated() }} | <a class="underlined" href="{{ $post->getLinkToPost() }}">{{ $post->getCommentsCountOrDiscuss() }}</a></p>
                @if( $post->hasText() )
                    <blockquote>
                        {!! $post->getText() !!}
                    </blockquote>
                @endif
            </div>

            @if( Auth::check())

                {{-- Display message when a comment is successfully entered. --}}
                @if( Session::has('comment_added'))
                    <div class="alert alert-success">
                        You comment was successfully added.
                    </div>
                @endif

                @include('layouts.partials.errors')
                {!! Form::open(['route' => 'comments.store']) !!}
                    {!! Form::hidden('post_id', $post->id) !!}
                    <!-- Comment Form Input -->
                    <div class="form-group {{ hasError('comment', $errors) }}">
                        {!! Form::textarea('comment', null, ['class' => 'form-control', 'placeholder' => "Say what's on your mind.", 'rows' => 5]) !!}
                    </div>
                    <!-- Submit Form Input -->
                    <div class="form-group">
                        {!! Form::submit('add comment', ['class' => 'btn btn-success']) !!}
                    </div>
                {!! Form::close() !!}
                <hr/>
            @else
                <div class="alert alert-info">Please log in if you'd like to leave a comment.</div>
            @endif
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">
            @include(Route::currentRouteName().'._comments', ['comments' => $post->parentComments])
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
@stop