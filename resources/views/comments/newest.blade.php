@extends('layouts.default')

@section('page_title')
    New Comments | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">
    <!-- .page-header -->
    <div class="page-header">
        <h1>Latest Comments</h1>
    </div>
    <!-- /.page-header -->
    @include(Route::currentRouteName().'._loop')
</div>
<!-- /.container -->
@stop

{{-- Embed javascript into the footer --}}
@section('footer_embedded_js')
    @include('comments._vote_embedded_js')
@stop