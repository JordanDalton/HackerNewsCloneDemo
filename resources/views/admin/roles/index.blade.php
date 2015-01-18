@extends($layout)

{{-- Set the page title --}}
@section('page_title')
    Roles | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">

    <!-- .breadcrumb -->
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><i class="fa fa-list"></i> Roles</li>
    </ol>
    <!-- /.breadcrumb -->

    <!-- .page-header -->
    <div class="page-header">
        <h1><i class="fa fa-roles"></i> Role <small>Management</small></h1>
        <p>Create, edit, update, and delete role records.</p>

        <div class="alert alert-info">
            <strong>Important</strong> - core roles cannot be modified or removed.
        </div>
    </div>
    <!-- /.page-header -->

    <!-- .row -->
    <div class="row">

        <!-- .col-lg-12 -->
        <div class="col-lg-6">

            @include('layouts.partials.searchform')

            <hr/>

            <a class="btn btn-md btn-success" href="{{ route('admin.roles.create') }}">
                Create New Role
            </a>

            <hr/>

            {{-- Alert if an role record was successfully created. --}}
            @if( Session::get('role_created_successfully'))
                <div class="alert alert-success">
                    Role record created successfully.
                </div>
            @endif

            {{-- Alert if role was updated successfully. --}}
            @if( Session::get('role_updated_successfully'))
                <div class="alert alert-success">
                    Role record updated successfully.
                </div>
            @endif

            {{-- Roles Table --}}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Actions</th>
                        <th>Name</th>
                        <th>Users</th>
                        <th>Core</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $roles as $role )
                    <tr class="{{ $role->trashed() ? 'danger' : '' }}">
                        <td>
                            {{-- Only show the edit button if the role is not a core role. --}}
                            @if( $role->isNotCore() )
                                <a class="btn btn-xs btn-info" href="{{ route('admin.roles.edit', $role->getId()) }}" title="Edit {{ $role->getName() }} Role">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $role->getName() }}</td>
                        <td>
                            <a class="btn btn-xs btn-info" href="{{ $role->getShowLink() }}">
                                <i class="fa fa-users"></i> {{ $role->users->count() }}
                            </a>
                        </td>
                        <td>
                            @if( $role->isCore() )
                                <i class="fa fa-check"></i>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Show the pagination links. --}}
            {!! $roles->appends( Request::all() )->render() !!}
        </div>
        <!-- /.col-lg-12 -->

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->
@stop