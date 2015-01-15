@if( $comments )
    @foreach( $comments as $comment )
        <?php $marginLeft = ! is_null($comment->parent_id) ? 5 : 0;?>
        <?php $marginLeft = isSet($isChild) ? $marginLeft + 5 : 0;?>
        <?php $marginLeft = isSet($currentMarginLeft) ? $marginLeft + $currentMarginLeft : $marginLeft;?>
        <div class="well well-sm comment-block {{ $comment->user_id == $post->user_id ? 'comment-by-poster' : '' }}" style="margin-left:{{ $marginLeft }}px">
            <div>
                <p>
                    {{-- Show message if user already voted. --}}
                    @if( $comment->votedByLoggedInUser())
                        <a class="btn btn-xs btn-success" href="#">
                            Voted
                        </a>
                    {{-- Otherwise show vote button --}}
                    @else
                        <a id="vote_up_comment_{{ $comment->getId() }}" class="btn btn-xs btn-info" href="#" data-target-url="{{ $comment->getVoteUrl() }}">
                            <i class="fa fa-arrow-up"></i>
                        </a>
                    @endif

                    <a class="underlined" href="{{ $comment->user->getProfileLink() }}">
                        {{ $comment->user->getUsername() }}
                    </a>
                    {{ $comment->getDurationSinceCreated() }} | <a class="underlined" href="{{ $comment->getLinkToComment() }}">Link</a>
                </p>
            </div>
            <blockquote>
                {!! $comment->getComment() !!}
            </blockquote>
        </div>
        <?php $comment->load('replies', 'replies.user');?>
        @include(Route::currentRouteName().'._comments', ['comments' => $comment->replies, 'isChild' => true, 'currentMarginLeft' => $marginLeft])
    @endforeach
@endif