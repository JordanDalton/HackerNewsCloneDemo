<?php namespace App\Providers;

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
