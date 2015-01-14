<?php namespace App\Providers;

use App\Comments\Comment;
use App\Comments\CommentObserver;
use App\Posts\Post;
use App\Posts\PostObserver;
use App\Votes\Vote;
use App\Votes\VoteObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        Comment::observe( new CommentObserver );
        Post::observe( new PostObserver );
        Vote::observe( new VoteObserver );
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
