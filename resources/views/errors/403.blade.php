@extends($layout)

{{-- Set the page title --}}
@section('page_title')
    Permission Denied | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">
    <!-- .page-header -->
    <div class="page-header">
        <h1>Permission Denied <small>Error 403</small></h1>
        <p class="lead">You do not have permission to access the page you were requesting.</p>
    </div>
    <!-- /.page-header -->
</div>
<!-- /.container -->
@stop