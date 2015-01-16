<?php namespace App\Layouts;

use Config;
use Illuminate\Contracts\View\View;

class EmailLayoutComposer {

    /**
     * Bind data to the view.
     *
     * @param \Illuminate\Contracts\View\View $view
     * @return void
     */
    public function compose( View $view )
    {
        $view->with('site_name', Config::get('settings.site_name'));
    }
} 