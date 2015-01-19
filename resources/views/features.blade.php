@extends($layout)

{{-- Set the title of the page. --}}
@section('page_title')
    Feature List | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">
    <!-- .row -->
    <div class="row">

        <!-- .page-header -->
        <div class="page-header">
            <h1>Feature List</h1>
            <p>We have gone through the process to mimic the features that are found on the Hacker News website.</p>
        </div>
        <!-- /.page-header -->

        <!-- .col-lg-8 -->
        <div class="col-lg-8">
            <h3>Backend Features</h3>
            <ul>
                    @foreach( $features['backend'] as $feature )
                        <li><strong>{{ $feature['label'] }}:</strong> {{ $feature['description'] }}</li>
                    @endforeach
            </ul>
            <h3>Frontend Features</h3>
            <ul>
                @foreach( $features['frontend'] as $feature )
                <li><strong>{{ $feature['label'] }}:</strong> {{ $feature['description'] }}</li>
                @endforeach
            </ul>
        </div>
        <!-- /.col-lg-8 -->
    </div>
    <!-- /.row -->
    <hr/>
</div>
<!-- /.container -->

@stop