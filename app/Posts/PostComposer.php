<?php namespace App\Posts;

use Illuminate\View\View;

class PostComposer {

    /**
     * The post repository implementation.
     *
     * @var PostRepositoryInterface
     */
    private $posts;

    /**
     * Create new PostComposer instance.
     *
     * @param PostRepositoryInterface $posts
     */
    public function __construct( PostRepositoryInterface $posts )
    {
        $this->posts = $posts;
    }

    /**
     * Compose the view.
     *
     * @param $view
     */
    public function compose( View $view )
    {
        $asks = [
            '*' => 'Select If Ask Record',
            '1' => 'Is Ask',
            '0' => 'Not Ask Record'
        ];

        $shows = [
            '*' => 'Select If Show Record',
            '1' => 'Is Show',
            '0' => 'Not Show Record'
        ];


        $view->with('asks', $asks);
        $view->with('shows', $shows);
    }
} 