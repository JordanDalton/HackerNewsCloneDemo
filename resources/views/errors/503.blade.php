@extends('layouts.default')

{{-- Set the page title --}}
@section('page_title')
    Be Right Back | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">
    <!-- .page-header -->
    <div class="page-header">
        <h1>Be Right Back</h1>
        <p class="lead">We're currently down for maintenance. Be right back.</p>
    </div>
    <!-- /.page-header -->
</div>
<!-- /.container -->
@stop