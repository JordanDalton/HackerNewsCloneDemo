<div class="row">
    <div class="col-md-12">
        <div class="media">
            <div class="media-body">
                <h4 class="media-heading">
                    <a id="vote_up_post_{{ $post->getId() }}" class="btn btn-xs btn-default" href="#" data-target-url="{{ $post->getVoteUrl() }}">
                        <i class="fa fa-arrow-up"></i>
                    </a>
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
                        {{ $post->getVoteCount() }} points by <a class="underlined" href="{{ $post->getLinkToPostersProfile() }}">{{ $post->user->getUsername() }}</a> {{ $post->getDurationSinceCreated() }} | <a class="underlined" href="{{ $post->getLinkToPost() }}">{{ $post->getCommentsCountOrDiscuss() }}</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<hr/>

@section('footer_embedded_js')
    <script type="text/javascript">
        $('a[id^="vote_up_post_"]').on('click', function(event)
        {
            event.preventDefault();

            // The url where the request will be sent.
            //
            var target_url = $(this).data('target-url');

            $.ajax({
                'type' : 'POST',
                'url'  : target_url,
                'data' : {
                    'now'   : $.now(),
                    '_token': '{{ csrf_token() }}'
                }
            }).done(function(response){
                console.log(response);
            });

            console.log('i was clicked');
        });
    </script>
@stop