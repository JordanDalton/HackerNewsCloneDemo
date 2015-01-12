<?php namespace App\Comments;

use App\Core\RepositoryTrait;

class CommentRepository implements CommentRepositoryInterface {

    use RepositoryTrait;

    /**
     * The comment model.
     *
     * @var Comment
     */
    private $model;

    /**
     * Create new CommentRepository instance.
     *
     * @param Comment $model
     */
    public function __construct( Comment $model )
    {
        $this->model = $model;
    }
} 