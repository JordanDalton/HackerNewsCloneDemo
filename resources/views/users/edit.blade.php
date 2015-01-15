@extends($layout)

{{-- Set the title of the page. --}}
@section('pageTitle')
    {{ $user->getUsername() }} | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">
            <!-- .page-header -->
            <div class="page-header">
                <h1>Edit Your Account Info</h1>
            </div>
            <!-- /.page-header -->

            {!! Form::model($user) !!}
                @include('users._fields')
            {!! Form::close() !!}
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
@stop