<?php

/**
 *
 * @param array $parameters
 *
 * @return array
 */
function dropBlankArrayValues( $parameters = [] )
{
    return array_filter($parameters, 'strlen');
}

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
 * Check if the user is an administrator.
 *
 * @return boolean
 */
function isAdmin()
{
    return Session::get('is_admin', function()
    {
        // Confirm if the user is an administrator.
        //
        $is_admin = Auth::check() && Auth::user()->hasRole('Administrators');

        // Push the status to the session.
        //
        Session::put('is_admin', $is_admin);
    });
}

/**
 * Return if the user is a admin or moderator.
 *
 * @return bool
 */
function isAdminOrModerator()
{
    return isAdmin() or isModerator();
}

/**
 * Check if the user is a moderator.
 *
 * @return boolean
 */
function isModerator()
{
    return Session::get('is_moderator', function()
    {
        // Confirm if the user is an administrator.
        //
        $is_moderator = Auth::check() && Auth::user()->hasRole('Moderators');

        // Push the status to the session.
        //
        Session::put('is_moderator', $is_moderator);
    });
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
 * Take a list of keywords and filter out any that are blank.
 *
 * @param array $keywords
 *
 * @return array
 */
function keywords( $keywords = [] )
{
    return dropBlankArrayValues( $keywords );
}

/**
 * Generate an array of key words from a given string.
 *
 * @param string $string
 * @return array
 */
function keywordsFromString( $string = '' )
{
    return keywords(explode(' ', $string));
}

/**
 * Return if a specified route name is not the current route name.
 *
 * @param $name
 *
 * @return bool
 */
function routeNameIsNot( $name )
{
    return Route::currentRouteName() !== $name;
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