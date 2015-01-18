@extends($layout)

{{-- Set the page title --}}
@section('page_title')
    Edit Comment {{ $comment->getId() }} | @parent
@stop

@section('content') 
<!-- .container -->
<div class="container">

    <!-- .breadcrumb -->
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('admin.comments.index') }}"><i class="fa fa-comments"></i> Comments</a></li>
        <li class="active"><i class="fa fa-comment"></i> {{ $comment->getId() }}</li>
    </ol>
    <!-- /.breadcrumb -->

    <!-- .page-header -->
    <div class="page-header">
        <h1><i class="fa fa-comment"></i> {{ $comment->getId() }} <small>(Edit Mode)</small></h1>
        <p></p>
    </div>
    <!-- /.page-header -->
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">

            {{-- Alert if an update was successful. --}}
            @if( Session::get('comment_updated_successfully'))
                <div class="alert alert-success">
                    Comment record updated successfully.
                </div>
            @endif

            @include('layouts.partials.errors')

            {!! Form::model($comment, ['method' => 'PUT', 'route' => ['admin.comments.update', $comment->getId()]]) !!}
                @include('admin.comments._fields')
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