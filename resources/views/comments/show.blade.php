@extends('layouts.default')

@section('pageTitle')
    {{ $comment->getTitleFriendlyComment() }} | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">
            <div class="page-header">
                <p>768 points by <a class="underlined" href="{{ $comment->user->getProfileLink() }}">{{ $comment->user->getUsername() }}</a> {{ $comment->user->getDurationSinceCreated() }} | <a class="underlined" href="{{ $comment->getLinkToC }}">Link</a> | <a class="underlined" href="{{ $comment->getLinkToParent() }}">Parent</a></p>
                <p class="lead">
                    <blockquote>
                        {!! $comment->getComment() !!}
                    </blockquote>
                </p>
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
                {!! Form::hidden('parent_id', $comment->getId()) !!}
                {!! Form::hidden('post_id', $comment->getPostId()) !!}
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
            @include(Route::currentRouteName().'._comments', ['comments' => $comment->replies])
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
@stop