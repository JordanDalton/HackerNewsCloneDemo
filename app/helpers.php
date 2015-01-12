<?php

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