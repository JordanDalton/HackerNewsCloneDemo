<div class="row">
    <div class="col-md-12">
        <div class="media">
            <div class="media-left">
                @if( $post->votedByLoggedInUser())
                    <a class="btn btn-xs btn-success" href="#">
                        Voted
                    </a>
                @else
                    <a id="vote_up_post_{{ $post->getId() }}" class="btn btn-xs btn-info" href="#" data-target-url="{{ $post->getVoteUrl() }}">
                        <i class="fa fa-arrow-up"></i>
                    </a>
                @endif

                {{-- Show admin edit link if the user is a administrator or moderator --}}
                @if( $_is_admin_or_moderator )
                    <div>
                        <a class="btn btn-xs btn-success" href="{!! $post->getAdminEditLink() !!}" style="margin-top:10px" target="_blank">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </div>
                @endif
            </div>
            <div class="media-body">
                <h4 class="media-heading">
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