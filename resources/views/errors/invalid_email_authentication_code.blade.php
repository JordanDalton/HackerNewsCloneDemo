@extends('layouts.default')

{{-- Set the page title --}}
@section('page_title')
Permission Denied | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">
    <!-- .page-header -->
    <div class="page-header">
        <h1>Invalid Code</h1>
        <p class="lead">The verification you provided is invalid.</p>
    </div>
    <!-- /.page-header -->
</div>
<!-- /.container -->
@stop