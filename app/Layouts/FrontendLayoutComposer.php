<?php namespace App\Layouts;

use Illuminate\Contracts\View\View;

class FrontendLayoutComposer {

    /**
     * Bind data to the view.
     *
     * @param \Illuminate\Contracts\View\View $view
     * @return void
     */
    public function compose( View $view )
    {
        $view->with('layout', 'layouts.default');
    }
} 