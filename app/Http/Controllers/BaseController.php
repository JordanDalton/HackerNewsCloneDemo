<?php namespace App\Http\Controllers;

use View;

class BaseController extends Controller {

    /**
     * Set the layout that is to be used.
     *
     * @var string
     */
    protected $layout = 'layouts.default';

    /**
     * Create new BaseController instance.
     */
    public function __construct()
    {
        View::share('layout', $this->layout);
    }
} 