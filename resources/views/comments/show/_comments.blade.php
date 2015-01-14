@if( $comments )
    @foreach( $comments as $comment )
        <?php $marginLeft = ! is_null($comment->parent_id) ? 20 : 0;?>
        <?php $marginLeft = isSet($isChild) ? $marginLeft + 20 : 0;?>
        <?php $marginLeft = isSet($currentMarginLeft) ? $marginLeft + $currentMarginLeft : $marginLeft;?>
        <div class="well well-sm comment-block" style="margin-left:{{ $marginLeft }}px">
            <div>
                <p>
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