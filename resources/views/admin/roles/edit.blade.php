@extends($layout)

{{-- Set the page title --}}
@section('page_title')
    Edit {{ $role->getName() }} | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">

    <!-- .breadcrumb -->
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('admin.roles.index') }}"><i class="fa fa-list"></i> Roles</a></li>
        <li class="active">{{ $role->getName() }}</li>
    </ol>
    <!-- /.breadcrumb -->

    <!-- .page-header -->
    <div class="page-header">
        <h1>{{ $role->getName() }} <small>(Edit Mode)</small></h1>
        <p></p>
    </div>
    <!-- /.page-header -->
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">

            {{-- Alert if an update was successful. --}}
            @if( Session::get('role_updated_successfully'))
                <div class="alert alert-success">
                    Role record updated successfully.
                </div>
            @endif

            @include('layouts.partials.errors')

            {!! Form::model($role, ['method' => 'PUT', 'route' => ['admin.roles.update', $role->getId()]]) !!}
                @include('admin.roles._fields')
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