<div class="row">
    <div class="col-md-12">
        <div class="media">
            <div class="media-body">
                <h4 class="media-heading">
                    @if( $post->votedByLoggedInUser())
                        <a class="btn btn-xs btn-success" href="#">
                            Voted
                        </a>
                    @else
                        <a id="vote_up_post_{{ $post->getId() }}" class="btn btn-xs btn-info" href="#" data-target-url="{{ $post->getVoteUrl() }}">
                            <i class="fa fa-arrow-up"></i>
                        </a>
                    @endif

                    <a href="{{ $post->getPostUrl() }}">
                        {{ $post->getTitle() }}
                    </a>
                    @if( $post->hasUrl() )
                        <small>
                            ({{ $post->getUrlDomain() }})
                        </small>
                    @endif
                </h4>
                <div>
                    <small>
                        {{ $post->getVoteCount() }} points by <a class="underlined" href="{{ $post->user->getProfileLink() }}">{{ $post->user->getUsername() }}</a> {{ $post->getDurationSinceCreated() }} | <a class="underlined" href="{{ $post->getLinkToPost() }}">{{ $post->showCommentsCountOrDiscuss() }}</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<hr/>

{{-- Embed javascript into the footer --}}
@section('footer_embedded_js')
    @include('posts._vote_embedded_js')
@stop