<?php namespace App\Comments;

use App\Core\BasePresenter;

class CommentPresenter extends BasePresenter {

    /**
     * Create new CommentPresenter instance.
     *
     * @param Comment $resource
     */
    public function __construct( Comment $resource )
    {
        $this->wrappedObject = $resource;
    }

    /**
     * Return the number of comments.
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->getWrappedObject()->count();
    }
} 