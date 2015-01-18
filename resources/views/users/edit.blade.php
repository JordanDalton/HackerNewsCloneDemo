@extends($layout)

{{-- Set the title of the page. --}}
@section('page_title')
    {{ $user->getUsername() }} | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">
            <!-- .page-header -->
            <div class="page-header">
                <h1>Edit Your Account Info</h1>
            </div>
            <!-- /.page-header -->

            {!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.update', $user->username]]) !!}
                @include('users._fields')
                <!-- Submit Form Input -->
                <div class="form-group">
                    {!! Form::submit('Update Account', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
@stop