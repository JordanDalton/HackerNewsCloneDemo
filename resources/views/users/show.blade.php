@extends($layout)

@section('content')
<!-- .container -->
<div class="container">
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">
            <div class="jumbotron">
                <h1><i class="fa fa-user"></i> {{ $user->getUsername() }}</h1>
                <dl class="dl-horizontal" style="background:#eee">
                    <dt>Joined</dt>
                    <dd>{{ $user->getDurationSinceCreated() }}</dd>
                    <dt>Karma</dt>
                    <dd>{{ $user->getKarmaScore() }}</dd>
                    <dt>Avg</dt>
                    <dd>{{ $user->getAverage() }}</dd>
                    <dt>About</dt>
                    <dd>@twitter</dd>
                    <dd><a href="#">submissions</a></dd>
                    <dd><a href="#">comments</a></dd>
                </dl>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
@stop