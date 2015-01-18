@extends('layouts.default')

{{-- Set the title of the page. --}}
@section('page_title')
    {{ $post->getTitle() }} | @parent
@stop

{{-- Set the content of the page --}}
@section('content')
<!-- .container -->
<div class="container">
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">
            <!-- .page-header-->
            <div class="page-header">

                {{-- If the user already voted then we will show a special message on the page --}}
                @if( $user_already_voted )
                    <span class="label label-success">You voted for this!</span>
                @endif

                {{-- Post Title Starts Here --}}
                <h1>

                    {{-- If the user hasn't already voted then we need to show the vote button --}}
                    @if( ! $user_already_voted )
                        <a id="vote_up_post_{{ $post->getId() }}" class="btn btn-xs btn-info" href="#" data-target-url="{{ $post->getVoteUrl() }}">
                            <i class="fa fa-arrow-up"></i>
                        </a>
                    @endif

                    {{-- Link Title --}}
                    <a href="{{ $post->getPostUrl() }}" target="_blank">{{ $post->getTitle() }}</a>
                    @if( $post->hasUrl() )
                        <small>({{ $post->getUrlDomain() }})</small>
                    @endif

                </h1>
                {{-- Post Title Ends Here --}}

                {{-- General Information Paragraph --}}
                <p>{{ $post->getVoteCount() }} points by <a class="underlined" href="{{ $post->user->getProfileLink() }}">{{ $post->user->getUsername() }}</a> {{ $post->getDurationSinceCreated() }} | <a class="underlined" href="{{ $post->getLinkToPost() }}">{{ $post->showCommentsCountOrDiscuss() }}</a></p>

                {{-- Only show the text if text is present. --}}
                {{-- Text will be presented as a quote. --}}
                @if( $post->hasText() )
                    <blockquote>
                        {!! $post->getText() !!}
                    </blockquote>
                @endif

            </div>
            <!-- /.page-header -->

            {{-- The following will only be shown if the user is logged in. --}}
            @if( Auth::check())

                {{-- Display message when a comment is successfully entered. --}}
                @if( Session::has('comment_added'))
                    <div class="alert alert-success">
                        You comment was successfully added.
                    </div>
                @endif

                {{-- This is where any validation errors will be shown --}}
                {{-- See resources/views/layouts/partials/errors.blade.php for usage details. --}}
                @include('layouts.partials.errors')

                {{-- This form will allow the user to post a comment. --}}
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
            {{-- Include our comments block loop --}}
            @include(Route::currentRouteName().'._comments', ['comments' => $post->parentComments])
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
@stop

{{-- Embed javascript into the footer --}}
@section('footer_embedded_js')
    @include('comments._vote_embedded_js')
    @include('posts._vote_embedded_js')
@stop