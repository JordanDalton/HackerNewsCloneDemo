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
        $view->with('_is_admin_or_moderator', $this->isAdminOrModerator() );
        $view->with('_is_moderator', $this->isModerator());
    }

    /**
     * Determine if the user is assigned to a administrator role.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return isAdmin();
    }

    /**
     * Determine if the user is an admin or moderator.
     *
     * @return bool
     */
    public function isAdminOrModerator()
    {
        return $this->isAdmin() OR $this->isModerator();
    }

    /**
     * Determine if the user is assigned to a moderator role.
     *
     * @return bool
     */
    public function isModerator()
    {
        return isModerator();
    }
} 