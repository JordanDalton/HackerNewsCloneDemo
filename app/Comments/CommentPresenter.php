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
     * Return the link to edit this record in the admin panel.
     *
     * @return string
     */
    public function getAdminEditLink()
    {
        return route('admin.comments.edit', $this->getWrappedObject()->id);
    }

    /**
     * Return the comment made.
     *
     * @param  bool $raw Return the raw response.
     * @return string
     */
    public function getComment( $raw = false )
    {
        // Obtain the comment from the record.
        //
        $comment = $this->getWrappedObject()->comment;

        // If $raw = true we will return the raw comment.
        //
        // Otherwise we will return it in a manner to where each new line
        // will become a <br>. We will also prevent the <br> from being
        // stripped out.
        //
        // This is what you would edit should you want additional tags such
        // as links to be shown.
        //
        return strip_tags( nl2br( $comment ), '<br>' );
    }

    /**
     * Return the comment in limited, short form.
     *
     * @param int $characters
     *
     * @return string
     */
    public function getCommentShort( $characters = 65 )
    {
        // Obtain the comment and strip out any html tags.
        //
        $comment = strip_tags( $this->getWrappedObject()->comment );

        // Return the limited comment string.
        //
        return str_limit( $comment , $characters );
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
     * Return the id of the comment.
     *
     * @return int
     */
    public function getId()
    {
        return $this->getWrappedObject()->id;
    }

    /**
     * Return the link to the show comment page.
     *
     * @return string
     */
    public function getLinkToComment()
    {
        return route('comments.show', $this->getWrappedObject()->id);
    }

    /**
     * Return the link to the parent item. Given that a comments may or may not have
     * a parent comment we will simply link pack to the post if not parent comment
     * is set.
     *
     * @return string
     */
    public function getLinkToParent()
    {
        // Check if there is no parent comment id set.
        //
        if( is_null( $this->getWrappedObject()->parent_id ) )
        {
            // Show the link to the post.
            //
            return route('posts.show', $this->getWrappedObject()->post_id);
        }

        // Show the link to the parent comment.
        //
        return route('comments.show', $this->getWrappedObject()->parent_id);
    }

    /**
     * Return the link to the page that the votes was casted to.
     *
     * @return string
     */
    public function getLinkToVotedRecord()
    {
        return $this->getLinkToComment();
    }

    /**
     * Return the parent id of the comment.
     *
     * @return int|null
     */
    public function getParentId()
    {
        return $this->getWrappedObject()->parent_id;
    }

    /**
     * Return the post id of the comment.
     *
     * @return int
     */
    public function getPostId()
    {
        return $this->getWrappedObject()->post_id;
    }

    /**
     * Convert the comment to a format that is title friendly in terms of it's length. This
     * will be helpful for SEO purposes.
     *
     * @return mixed
     */
    public function getTitleFriendlyComment()
    {
        return str_limit( $this->getComment(true), 45 );
    }

    /**
     * Return the voteable type.
     *
     * @return string
     */
    public function getVoteableType()
    {
        return 'Comment';
    }

    /**
     * Return the number of votes.
     *
     * @return int
     */
    public function getVoteCount()
    {
        return $this->getWrappedObject()->votes;
    }

    /**
     * Return the url where the votes will be casted.
     *
     * @return string
     */
    public function getVoteUrl()
    {
        return route('comments.vote', $this->getWrappedObject()->id);
    }
} 