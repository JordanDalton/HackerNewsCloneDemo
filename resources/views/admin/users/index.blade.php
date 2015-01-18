@extends($layout)

{{-- Set the page title --}}
@section('page_title')
    Users | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">

    <!-- .breadcrumb -->
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><i class="fa fa-users"></i> Users</li>
    </ol>
    <!-- /.breadcrumb -->

    <!-- .page-header -->
    <div class="page-header">
        <h1><i class="fa fa-users"></i> User <small>Management</small></h1>
        <p>Create, edit, update, and delete user records.</p>
    </div>
    <!-- /.page-header -->

    <!-- .row -->
    <div class="row">

        <!-- .col-lg-12 -->
        <div class="col-lg-12">

            <h3>Search <small>Users</small></h3>
            {!! Form::open(['method' => 'GET']) !!}
            <!-- .row -->
            <div class="row">
                {{-- Make the user aware of any search filters being applied to the results. --}}
                @include('layouts.partials.search_filters_applied', ['searchGroup' => 'user'])

                <!-- .col-lg-4 -->
                <div class="col-lg-4">
                    {!! Form::text('user[username]', Input::get('user.username', ''), ['class' => 'form-control', 'placeholder' => 'johnSmith']) !!}
                </div>
                <!-- /.col-lg-4 -->
                <!-- .col-lg-4 -->
                <div class="col-lg-4">
                    {!! Form::text('user[email]', Input::get('user.email', ''), ['class' => 'form-control', 'placeholder' => 'john.smith@johnsmith.com']) !!}
                </div>
                <!-- /.col-lg-4 -->
                <!-- .col-lg-2 -->
                <div class="col-lg-2">
                    {!! Form::button('Search', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                </div>
                <!-- /.col-lg-2 -->
            </div>
            <!-- /.row -->
            {!! Form::close() !!}

            <hr/>
            {{-- Users Table --}}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Actions</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Joined</th>
                        <th>Stats</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $users as $user )
                    <tr class="{{ $user->trashed() ? 'danger' : '' }}">
                        <td>
                            <a class="btn btn-xs btn-success" href="{{ $user->getProfileLink() }}" title="View {{ $user->getUsername() }} Profile">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-xs btn-info" href="{{ route('admin.users.edit', $user->getId()) }}" title="Edit {{ $user->getUsername() }} Profile">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                        <td>{{ $user->getUsername() }}</td>
                        <td>{{ $user->getEmail() }}</td>
                        <td>{{ $user->getDurationSinceCreated() }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="">
                                <a class="btn btn-xs btn-default" href="{{ route('admin.posts.index',    ['post[user_id]' => $user->getId()]) }}">Posts</a>
                                <a class="btn btn-xs btn-default" href="{{ route('admin.comments.index', ['comment[user_id]' => $user->getId()]) }}">Comments</a>
                                <a class="btn btn-xs btn-default" href="{{ route('admin.votes.index',    ['votes[user_id]' => $user->getId()]) }}">Votes</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Show the pagination links. --}}
            {!! $users->appends( Request::all() )->render() !!}
        </div>
        <!-- /.col-lg-12 -->

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->
@stop