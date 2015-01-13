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
     * Return the comment made.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->getWrappedObject()->comment;
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

    /**
     * Get the difference in a human readable format for the duration since the comment was created.
     *
     * @return string
     */
    public function getDurationSinceCreated()
    {
        return $this->getWrappedObject()->created_at->diffForHumans();
    }

    /**
     * Return the link to the show comment page.
     *
     * @return string
     */
    public function getShowLink()
    {
        return route('comments.show', $this->getWrappedObject()->id);
    }
} 