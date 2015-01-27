@extends('layouts.default')

@section('page_title')
    Welcome | @parent
@stop

@section('content')
<div class="container">

    @include('layouts.partials.errors')

    <div class="jumbotron">
        <h1>Hacker News Clone</h1>
        <p><strong>{{ $site_name }}</strong> is a powerful script that allows you create your own socially driven content website. This script is built on <a href="http://www.laravel.com">Laravel 5</a>, one of the most modern development frameworks in the history of PHP. With this script you can be online and running in a matter of minutes. <br/></p>
        <p>Feel free to try out this demo site which is reset every 15 minutes.</p>

        <p>
            <form class="pull-left" action='https://www.2checkout.com/checkout/purchase' method='post'>
                <input type='hidden' name='sid' value='202460720'>
                <input type='hidden' name='quantity' value='1'>
                <input type='hidden' name='product_id' value='1'>
                <input class="btn btn-primary btn-lg" name='submit' type='submit' value='Buy from 2CO' >
            </form>
            <a class="btn btn-success btn-lg" href="{!! route('features') !!}" role="button" style="margin-left:10px">View Features</a>
        </p>
    </div>

    @if( ! count($posts) )
    <div class="alert alert-warning">
        There are currently no posts to list.
    </div>
    @endif

    @foreach( $posts as $post )
        @include(Route::currentRouteName().'._loop')
    @endforeach

    <div class="row">
        <div class="col-lg-12">
            {{-- Display the pagination links. --}}
            {!! $posts->appends( Request::all() )->render() !!}
        </div>
    </div>
</div>
@stop