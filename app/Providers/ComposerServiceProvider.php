<?php namespace App\Providers;

use App\Layouts\EmailLayoutComposer;
use App\Roles\RoleComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;
use App\Layouts\FrontendLayoutComposer;

class ComposerServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
     * @param ViewFactory $view
	 * @return void
	 */
	public function boot( ViewFactory $view )
	{
        $view->composer('*', FrontendLayoutComposer::class);
        $view->composer('*', EmailLayoutComposer::class);
        $view->composer('admin.*', RoleComposer::class);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
