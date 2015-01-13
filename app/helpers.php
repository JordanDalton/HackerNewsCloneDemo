<?php

/**
 * If a particular form field has a known error we will
 * return a string that will represent a error field.
 *
 * @param string $name The name of the error that we're checking for.
 * @param Illuminate\Support\ViewErrorBag $errors The error message bag.
 *
 * @return string
 */
function hasError( $name , Illuminate\Support\ViewErrorBag $errors )
{
    return $errors->has( $name ) ? 'has-error' : '#';
}

/**
 * Return the dot-notational path to the view which
 * matches tha alias name of the active route.
 *
 * @return string
 */
function routeView()
{
    return view(Route::currentRouteName());
}

/**
 * Take the current route name and convert to css selector
 * @return mixed
 */
function routeToCssName()
{
    return str_replace('.', '_', Route::currentRouteName());
}