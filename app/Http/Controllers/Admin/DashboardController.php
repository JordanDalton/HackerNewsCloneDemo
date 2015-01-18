<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller {

    /**
     * Administrative Dashboard Page
     *
     * @return View
     */
    public function index()
    {
        return routeView();
    }
} 