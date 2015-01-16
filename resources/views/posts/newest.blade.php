@extends('layouts.default')

@section('pageTitle')
    Newest | @parent
@stop

@section('content')
<div class="container">
    <!-- .page-header -->
    <div class="page-header">
        <h1>Latest Submissions</h1>
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