@extends('layouts.default')

@section('page_title')
    Submitted By {{ $username }} | @parent
@stop

@section('content')
<div class="container">

    <div class="page-header">
        <h1>Posts <small>Submitted By {{ $username }}</small></h1>
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