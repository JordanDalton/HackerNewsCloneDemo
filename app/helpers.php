<?php

/**
 * A defined list of usernames that we will not allowed to be registered.
 *
 * @return array
 */
function disallowedUsernameList()
{
    return [
        'admin',
        'administrator',
        'customerservice',
        'customer_service',
        'support'
    ];
}

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
 * Determine of if a specified route is currently be viewed.
 *
 * @param string $routeName The dot notational route name.
 * @param string $trueReturn The value we want returned if there is a match.
 * @param string $falseReturn The value we want returnd if there is NOT a match.
 *
 * @return string
 */
function isActiveRouteName( $routeName , $trueReturn = 'active' , $falseReturn = '#' )
{
    return Route::currentRouteName() === $routeName ? $trueReturn : $falseReturn;
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