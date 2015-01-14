@if( ! count($comments) )
    <div class="alert alert-warning">
        There are currently no comments to list.
    </div>
@endif

@foreach( $comments as $comment )
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">
            <div>
                <p>
                    <a id="vote_up_comment_{{ $comment->getId() }}" class="btn btn-xs btn-default" href="#">
                        <i class="fa fa-arrow-up"></i>
                    </a>
                    {{ $comment->getVoteCount() }} points by
                    <a class="underlined" href="{{ $comment->user->getProfileLink() }}">
                        {{ $comment->user->getUsername() }}
                    </a>
                    {{ $comment->user->getDurationSinceCreated() }}
                    | <a class="underlined" href="{{ $comment->getId() }}">Link</a>
                    | <a class="underlined" href="{{ $comment->getLinkToParent() }}">Parent</a>
                    | on: <a class="underlined" href="{{ $comment->post->getLinkToPost() }}">{{ $comment->post->getTitle() }}</a></p>
                <p class="lead">
                <blockquote>
                    {!! $comment->getComment() !!}
                </blockquote>
                </p>
            </div>
            <hr/>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
@endforeach