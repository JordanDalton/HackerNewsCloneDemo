<?php
/*
 * Use the following to include this file in your blade layout:
 *  @include('layouts.partials.errors')
 *
 * To use a different message bag simply pass an array as the second parameter:
 *  @include('layouts.partials.errors', ['bag' => 'BagName']])
 */
?>
<?php $bag = isSet($bag) ? $bag : 'default';?>
@if ( $errors->$bag->count() )
    @foreach( $errors->$bag->all() as $error )
        <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
@endif