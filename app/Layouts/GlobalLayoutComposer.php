<?php namespace App\Layouts;

use Auth;
use Illuminate\View\View;
use Session;

class GlobalLayoutComposer {

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose( View $view )
    {
        $view->with('site_name', config('settings.site_name'));
        $view->with('_is_admin', $this->isAdmin());
        $view->with('_is_admin_or_moderator', $this->isAdmin() OR $this->isModerator());
        $view->with('_is_moderator', $this->isModerator());
    }

    /**
     * Determine if the user is assigned to a administrator role.
     *
     * @return bool
     */
    public function isAdmin()
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
     * Determine if the user is assigned to a moderator role.
     *
     * @return bool
     */
    public function isModerator()
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
} 