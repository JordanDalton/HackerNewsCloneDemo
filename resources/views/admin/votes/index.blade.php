@extends($layout)

{{-- Set the page title --}}
@section('page_title')
    Votes | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">

    <!-- .breadcrumb -->
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><i class="fa fa-thumbs-up"></i> Votes</li>
    </ol>
    <!-- /.breadcrumb -->

    <!-- .page-header -->
    <div class="page-header">
        <h1><i class="fa fa-thumbs-up"></i> Vote <small>Management</small></h1>
        <p>Manage votes that have been casted.</p>
    </div>
    <!-- /.page-header -->

    <!-- .row -->
    <div class="row">

        <!-- .col-lg-12 -->
        <div class="col-lg-12">

            <h3>Search <small>Votes</small></h3>
            {!! Form::open(['method' => 'GET']) !!}
            <!-- .row -->
            <div class="row">
                {{-- Make the vote aware of any search filters being applied to the results. --}}
                @include('layouts.partials.search_filters_applied', ['searchGroup' => 'vote'])

                <!-- .col-lg-4 -->
                <div class="col-lg-3">
                    {!! Form::text('vote[voteable_type]', Input::get('vote.voteable_type', ''), ['class' => 'form-control', 'placeholder' => 'Voteable Type: Comment or Post']) !!}
                </div>
                <!-- /.col-lg-4 -->
                <!-- .col-lg-4 -->
                <div class="col-lg-2">
                    {!! Form::text('vote[voteable_id]', Input::get('vote.voteable_id', ''), ['class' => 'form-control', 'placeholder' => 'Voteable ID: 12']) !!}
                </div>
                <!-- /.col-lg-4 -->
                <!-- .col-lg-4 -->
                <div class="col-lg-4">
                    {!! Form::select('vote[user_id]', $users, Input::get('vote.user_id', 0), ['class' => 'form-control']) !!}
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
                        <th>Delete</th>
                        <th>Voteable Type</th>
                        <th>Voteable ID</th>
                        <th>Voted By</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $votes as $vote )
                    <tr class="{{ $vote->trashed() ? 'danger' : '' }}">
                        <td>
                            <a class="btn btn-xs btn-danger" href="" data-target-url="{{ route('admin.votes.destroy', $vote->getId()) }}" title="Delete Vote">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                        <td>
                            {{ $vote->voteable->getVoteableType() }}
                        </td>
                        <td>
                            <a class="btn btn-xs btn-primary" href="{{ $vote->voteable->getLinkToVotedRecord() }}">
                                {{ $vote->voteable->getId() }}
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-xs btn-info" href="{{ $vote->user->getProfileLink() }}">
                                <i class="fa fa-user"></i> {{ $vote->user->getUsername() }}
                            </a>
                        </td>
                        <td>{{ $vote->getDurationSinceCreated() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Show the pagination links. --}}
            {!! $votes->appends( Request::all() )->render() !!}
        </div>
        <!-- /.col-lg-12 -->

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->
@stop