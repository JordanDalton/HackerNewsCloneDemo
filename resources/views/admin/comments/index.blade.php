@extends($layout)

{{-- Set the page title --}}
@section('page_title')
    Comments | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">

    <!-- .breadcrumb -->
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><i class="fa fa-comments"></i> Comments</li>
    </ol>
    <!-- /.breadcrumb -->

    <!-- .page-header -->
    <div class="page-header">
        <h1><i class="fa fa-comments"></i> Comment <small>Management</small></h1>
        <p>Manage all comment records.</p>
    </div>
    <!-- /.page-header -->

    <!-- .row -->
    <div class="row">

        <!-- .col-lg-12 -->
        <div class="col-lg-12">

            <h3>Search <small>Comments</small></h3>
            {!! Form::open(['method' => 'GET']) !!}
            <!-- .row -->
            <div class="row">
                {{-- Make the user aware of any search filters being applied to the results. --}}
                @include('layouts.partials.search_filters_applied', ['searchGroup' => 'user'])

                <!-- .col-lg-4 -->
                <div class="col-lg-4">
                    {!! Form::text('comment[comment]', Input::get('comment.comment', ''), ['class' => 'form-control', 'placeholder' => 'Comment search']) !!}
                </div>
                <!-- /.col-lg-4 -->
                <!-- .col-lg-4 -->
                <div class="col-lg-4">
                    {!! Form::select('comment[user_id]', $users, Input::get('comment.user_id', '*'), ['class' => 'form-control']) !!}
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
            {{-- Comments Table --}}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Actions</th>
                        <th>Comment</th>
                        <th>User</th>
                        <th>Parent</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $comments as $comment )
                    <tr class="{{ $comment->trashed() ? 'danger' : '' }}">
                        <td>
                            <a class="btn btn-xs btn-success" href="{{ $comment->getLinkToComment() }}" title="View Comment">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-xs btn-info" href="{{ route('admin.comments.edit', $comment->getId()) }}" title="Edit Comment">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                        <td>{{ $comment->getCommentShort() }}</td>
                        <td>
                            <a class="btn btn-xs btn-info" href="{{ $comment->user->getProfileLink() }}">
                                <i class="fa fa-user"></i> {{ $comment->user->getUsername() }}
                            </a>
                        </td>
                        <td>
                            <a class="underlined" href="{{ $comment->getLinkToParent() }}">
                                Parent
                            </a>
                        </td>
                        <td>
                            {{ $comment->getDurationSinceCreated() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Show the pagination links. --}}
            {!! $comments->appends( Request::all() )->render() !!}
        </div>
        <!-- /.col-lg-12 -->

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->
@stop