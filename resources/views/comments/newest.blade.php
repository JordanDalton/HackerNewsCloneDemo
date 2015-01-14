@extends('layouts.default')

@section('pageTitle')
    New Comments | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">

    <div class="jumbotron">
        <h1>Newest Comments</h1>
    </div>

    @include(Route::currentRouteName().'._loop')
</div>
<!-- /.container -->
@stop