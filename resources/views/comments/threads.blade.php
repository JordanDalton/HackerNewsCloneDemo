@extends('layouts.default')

@section('page_title')
    Your Comments | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">
    <!-- .page-header -->
    <div class="page-header">
        <h1>Comments <small>Posted By You</small></h1>
    </div>
    <!-- /.page-header -->
    @include(Route::currentRouteName().'._loop')

    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">
            {{-- Display the pagination links. --}}
            {!! $comments->appends( Request::all() )->render() !!}
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
@stop

{{-- Embed javascript into the footer --}}
@section('footer_embedded_js')
    @include('comments._vote_embedded_js')
@stop