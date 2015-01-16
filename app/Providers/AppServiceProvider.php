<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);

        // Interface to Respository Bindings
        //
        $this->app->bind(
            'App\Comments\CommentRepositoryInterface',
            'App\Comments\CommentRepository'
        );

        $this->app->bind(
            'App\Items\ItemRepositoryInterface',
            'App\Items\ItemRepository'
        );

        $this->app->bind(
            'App\Posts\PostRepositoryInterface',
            'App\Posts\PostRepository'
        );

        $this->app->bind(
            'App\Roles\RoleRepositoryInterface',
            'App\Roles\RoleRepository'
        );

        $this->app->bind(
            'App\Users\UserRepositoryInterface',
            'App\Users\UserRepository'
        );

        $this->app->bind(
            'App\Votes\VoteRepositoryInterface',
            'App\Votes\VoteRepository'
        );
	}

}
