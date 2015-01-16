@extends($layout)

{{-- Set the page title --}}
@section('page_title')
    Edit {{ $user->getUsername() }} | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">
    <!-- .page-header -->
    <div class="page-header">
        <h1><i class="fa fa-user"></i> {{ $user->getUsername() }} <small>(Edit Mode)</small></h1>
        <p></p>
    </div>
    <!-- /.page-header -->
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">
            {!! Form::model($user) !!}
                @include('admin.users._fields')
                <!-- Submit Form Input -->
                <div class="form-group">
                    {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
@stop