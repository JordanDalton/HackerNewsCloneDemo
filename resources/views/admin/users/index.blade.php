@extends($layout)

{{-- Set the page title --}}
@section('page_title')
    Users | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">
    <!-- .page-header -->
    <div class="page-header">
        <h1>User <small>Management</small></h1>
        <p>Create, edit, update, and delete user records.</p>
    </div>
    <!-- /.page-header -->
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Edit</th>
                        <th>Username</th>
                        <th>Joined</th>
                        <th>Email</th>
                        <th>Stats</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $users as $user )
                    <tr>
                        <td>
                            <a class="btn btn-xs btn-info" href="{{ route('admin.users.edit', $user->getId()) }}">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                        <td>{{ $user->getUsername() }}</td>
                        <td>{{ $user->getEmail() }}</td>
                        <td>{{ $user->getDurationSinceCreated() }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="">
                                <a class="btn btn-xs btn-default" href="{{ route('admin.posts.index', ['user_id' => $user->getId()]) }}">Posts</a>
                                <a class="btn btn-xs btn-default" href="{{ route('admin.comments.index', ['user_id' => $user->getId()]) }}">Comments</a>
                                <a class="btn btn-xs btn-default" href="{{ route('admin.votes.index', ['user_id' => $user->getId()]) }}">Votes</a>
                            </div>
                        </td>
                        <td>
                            <a class="btn btn-xs btn-danger" href="#" data-target-url="{{ $user->getId() }}">
                                <i class="fa fa-trash"></i>
                            </a>
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