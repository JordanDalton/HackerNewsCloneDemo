@extends($layout)

{{-- Set the page title --}}
@section('page_title')
    Edit {{ $user->getUsername() }} | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">

    <!-- .breadcrumb -->
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('admin.users.index') }}"><i class="fa fa-users"></i> Users</a></li>
        <li class="active"><i class="fa fa-user"></i> {{ $user->getUsername() }}</li>
    </ol>
    <!-- /.breadcrumb -->

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

            {{-- Alert if an update was successful. --}}
            @if( Session::get('user_updated_successfully'))
                <div class="alert alert-success">
                    User record updated successfully.
                </div>
            @endif

            @include('layouts.partials.errors')

            {!! Form::model($user, ['method' => 'PUT', 'route' => ['admin.users.update', $user->getId()]]) !!}
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