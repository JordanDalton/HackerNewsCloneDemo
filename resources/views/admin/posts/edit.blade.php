@extends($layout)

{{-- Set the page title --}}
@section('page_title')
    Edit Post {{ $post->getId() }} | @parent
@stop

@section('content') 
<!-- .container -->
<div class="container">

    <!-- .breadcrumb -->
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('admin.posts.index') }}"><i class="fa fa-list"></i> Posts</a></li>
        <li class="active">Post #{{ $post->getId() }}</li>
    </ol>
    <!-- /.breadcrumb -->

    <!-- .page-header -->
    <div class="page-header">
        <h1><i class="fa fa-post"></i> Post #{{ $post->getId() }} <small>(Edit Mode)</small></h1>
        <p><strong>{{ $post->getTitle() }}</strong></p>
    </div>
    <!-- /.page-header -->
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">

            {{-- Alert if an update was successful. --}}
            @if( Session::get('post_updated_successfully'))
                <div class="alert alert-success">
                    Post record updated successfully.
                </div>
            @endif

            @include('layouts.partials.errors')

            {!! Form::model($post, ['method' => 'PUT', 'route' => ['admin.posts.update', $post->getId()]]) !!}
                @include('admin.posts._fields')
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