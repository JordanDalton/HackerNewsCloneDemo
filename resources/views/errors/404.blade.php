@extends($layout)

{{-- Set the page title --}}
@section('page_title')
    Page Not Found | @parent
@stop

@section('content')
    <!-- .container -->
    <div class="container">
        <!-- .page-header -->
        <div class="page-header">
            <h1>Error <small>404</small></h1>
            <p class="lead">The page you attempted to access does not exist, or has been removed.</p>
        </div>
        <!-- /.page-header -->
    </div>
    <!-- /.container -->
@stop