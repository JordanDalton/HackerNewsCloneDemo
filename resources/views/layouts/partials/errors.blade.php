<?php $bag = isSet($bag) ? $bag : 'default';?>
@if ( $errors->$bag->count() )
    @foreach( $errors->$bag->all() as $error )
        <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
@endif