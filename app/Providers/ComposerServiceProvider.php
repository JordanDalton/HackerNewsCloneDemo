<?php namespace App\Providers;

use App\Charts\ChartComposer;
use App\Layouts\AdminLayoutComposer;
use App\Layouts\EmailLayoutComposer;
use App\Layouts\GlobalLayoutComposer;
use App\Posts\PostComposer;
use App\Roles\RoleComposer;
use App\Users\UserComposer;
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
        $view->composer('*', GlobalLayoutComposer::class);
        $view->composer('*', FrontendLayoutComposer::class);
        $view->composer('*', EmailLayoutComposer::class);
        $view->composer('admin.posts.*', PostComposer::class);
        $view->composer('admin.users.*', RoleComposer::class);
        $view->composer(['admin.comments.*', 'admin.posts.*', 'admin.votes.*'], UserComposer::class);
        $view->composer('admin.dashboard.index', ChartComposer::class);

        // Keep this one at the bottom.
        //
        $view->composer('admin.*', AdminLayoutComposer::class);
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
