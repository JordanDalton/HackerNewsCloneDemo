@extends('layouts.default')

@section('page_title')
    {{ $comment->getTitleFriendlyComment() }} | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">
            <!-- .page-header -->
            <div class="page-header">

                {{-- If the user already voted then we will show a special message on the page --}}
                @if( $user_already_voted )
                    <span class="label label-success">You voted for this!</span>
                @endif

                <p>
                    {{-- If the user hasn't already voted then we need to show the vote button --}}
                    @if( ! $user_already_voted )
                        <a id="vote_up_post_{{ $comment->getId() }}" class="btn btn-xs btn-info" href="#" data-target-url="{{ $comment->getVoteUrl() }}">
                            <i class="fa fa-arrow-up"></i>
                        </a>
                    @endif

                    {{ $comment->getVoteCount() }} points by <a class="underlined" href="{{ $comment->user->getProfileLink() }}">{{ $comment->user->getUsername() }}</a> {{ $comment->user->getDurationSinceCreated() }}
                    | <a class="underlined" href="{{ $comment->getLinkToC }}">Link</a>
                    | <a class="underlined" href="{{ $comment->getLinkToParent() }}">Parent</a>
                </p>
                <p class="lead">
                    <blockquote>
                        {!! $comment->getComment() !!}
                    </blockquote>
                </p>
            </div>
            <!-- /.page-header-->

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