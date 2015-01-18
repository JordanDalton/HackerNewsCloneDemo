@extends($layout)

{{-- Set the page title --}}
@section('page_title')
    Posts | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">

    <!-- .breadcrumb -->
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><i class="fa fa-list"></i> Posts</li>
    </ol>
    <!-- /.breadcrumb -->

    <!-- .page-header -->
    <div class="page-header">
        <h1><i class="fa fa-comments"></i> Post <small>Management</small></h1>
        <p>Manage all post records.</p>
    </div>
    <!-- /.page-header -->

    <!-- .row -->
    <div class="row">

        <!-- .col-lg-12 -->
        <div class="col-lg-12">

            <h3>Search <small>Posts</small></h3>
            {!! Form::open(['method' => 'GET']) !!}
            <!-- .row -->
            <div class="row">
                {{-- Make the user aware of any search filters being applied to the results. --}}
                @include('layouts.partials.search_filters_applied', ['searchGroup' => 'post'])

                <!-- .col-lg-4 -->
                <div class="col-lg-4">
                    {!! Form::text('post[title]', Input::get('post.title', ''), ['class' => 'form-control', 'placeholder' => 'Title Search']) !!}
                </div>
                <!-- /.col-lg-4 -->
                <!-- .col-lg-4 -->
                <div class="col-lg-4">
                    <hr class="visible-xs visible-sm visible-md"/>
                    {!! Form::text('post[url]', Input::get('post.url', ''), ['class' => 'form-control', 'placeholder' => 'Url Search']) !!}
                </div>
                <!-- /.col-lg-4 -->
                <!-- .col-lg-4 -->
                <div class="col-lg-4">
                    <hr class="visible-xs visible-sm visible-md"/>
                    {!! Form::text('post[text]', Input::get('post.text', ''), ['class' => 'form-control', 'placeholder' => 'Text Search']) !!}
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
            <!-- .row -->
            <div class="row">
                <!-- .col-lg-4 -->
                <div class="col-lg-4">
                    <hr/>
                    {!! Form::select('post[ask]', $asks, Input::get('post.ask', '*'), ['class' => 'form-control'])  !!}
                </div>
                <!-- /.col-lg-4 -->
                <!-- .col-lg-4 -->
                <div class="col-lg-4">
                    <hr/>
                    {!! Form::select('post[show]', $shows, Input::get('post.show', '*'), ['class' => 'form-control'])  !!}
                </div>
                <!-- /.col-lg-4 -->
                <!-- .col-lg-4 -->
                <div class="col-lg-4">
                    <hr/>
                    {!! Form::select('post[user_id]', $users, Input::get('post.user_id', '*'), ['class' => 'form-control'])  !!}
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
            <!-- .row -->
            <div class="row">
                <!-- .col-lg-2 -->
                <div class="col-lg-2">
                    <hr/>
                    {!! Form::button('Search Posts', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                </div>
                <!-- /.col-lg-2 -->

            </div>
            <!-- /.row -->
            {!! Form::close() !!}

            <hr/>
            {{-- Post Table --}}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Actions</th>
                        <th>Ask</th>
                        <th>Show</th>
                        <th>Title</th>
                        <th>Url</th>
                        <th>User</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $posts as $post )
                    <tr class="{{ $post->trashed() ? 'danger' : '' }}">
                        <td>
                            <a class="btn btn-xs btn-success" href="{{ $post->getLinkToPost() }}" title="View Comment">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-xs btn-info" href="{{ route('admin.posts.edit', $post->getId()) }}" title="Edit Comment">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                        <td>
                            @if( $post->isAsk() )
                                <i class="fa fa-check"></i>
                            @endif
                        </td>
                        <td>
                            @if( $post->isShow() )
                            <i class="fa fa-check-square"></i>
                            @endif
                        </td>
                        <td>{{ $post->getTitle() }}</td>
                        <td>
                            @if( $post->getUrl() )
                                <a class="btn btn-xs btn-info" href="{{ $post->getUrl() }}">
                                    <i class="fa fa-external-link"></i>
                                    {{ $post->getUrlDomain() }}
                                </a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-xs btn-primary" href="{{ $post->user->getProfileLink() }}">
                                <i class="fa fa-user"></i> {{ $post->user->getUsername() }}
                            </a>
                        </td>
                        <td>
                            {{ $post->getDurationSinceCreated() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Show the pagination links. --}}
            {!! $posts->appends( Request::all() )->render() !!}
        </div>
        <!-- /.col-lg-12 -->

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->
@stop