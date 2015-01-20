@extends($layout)

{{-- Set the title of the page. --}}
@section('page_title')
    {{ $user->getUsername() }} | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">
            <div class="jumbotron">
                <h1><i class="fa fa-user"></i> {{ $user->getUsername() }}</h1>
                <dl class="dl-horizontal">
                    <dt>Joined</dt>
                    <dd>{{ $user->getDurationSinceCreated() }}</dd>
                    <dt>Karma</dt>
                    <dd>{{ $user->getKarmaScore() }}</dd>
                    <dt>Avg</dt>
                    <dd>{{ $user->getAverage() }}</dd>
                    <dt>About</dt>
                    <dd>{!! $user->getAbout() !!}</dd>
                    <dd><a class="underlined" href="{{ route('posts.submitted', ['username' => $user->getUsername()]) }}">submissions</a></dd>
                    <dd><a class="underlined" href="{{ route('comments.threads', ['username' => $user->getUsername()]) }}">comments</a></dd>
                </dl>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
@stop