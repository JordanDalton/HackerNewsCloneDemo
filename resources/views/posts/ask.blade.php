@extends('layouts.default')

@section('pageTitle')
    Ask | @parent
@stop

@section('content')
<div class="container">

    <div class="jumbotron">
        <h1>Ask {{ $site_name }}</h1>
    </div>

    @foreach( $posts as $post )
        @include(Route::currentRouteName().'._loop')
    @endforeach

    <div class="row">
        <div class="col-lg-12">
            {{-- Display the pagination links. --}}
            {!! $posts->appends( Request::all() )->render() !!}
        </div>
    </div>
</div>
@stop