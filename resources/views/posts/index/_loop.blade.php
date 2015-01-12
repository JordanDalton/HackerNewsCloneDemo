<div class="row">
    <div class="col-md-12">
        <div class="media">
            <div class="media-left media-middle">
                <a class="btn btn-default" href="#">
                    <i class="fa fa-arrow-up"></i>
                    10,234
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading">
                    <a href="{{ $post->getUrl() }}">
                        {{ $post->getTitle() }}
                    </a>
                    <small>
                        ({{ $post->getUrlDomain() }})
                    </small>
                </h4>
                <div>
                    <small>
                        by <a class="underlined" href="{{ $post->getLinkToPostersProfile() }}">{{ $post->getUsernameOfPoster() }}</a> {{ $post->getDurationSinceCreated() }} | <a class="underlined" href="{{ $post->getLinkToPost() }}">{{ $post->getCommentsCountOrDiscuss() }}</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<hr/>