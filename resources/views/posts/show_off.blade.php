@extends('layouts.default')

@section('pageTitle')
    Show | @parent
@stop

@section('content')
    <div class="container">
        <!-- .page-header -->
        <div class="page-header">
            <h1>Show Us Your Site!</h1>
            <p>Getting opinions on your site. You never know, you may just be next Google!</p>
        </div>
        <!-- /.page-header -->

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