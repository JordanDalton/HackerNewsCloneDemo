<?php namespace App\Posts;

use App\Core\BasePresenter;
use Lang;

class PostPresenter extends BasePresenter {

    /**
     * Create new PostPresenter instance.
     *
     * @param Post $resource
     */
    public function __construct( Post $resource )
    {
        $this->wrappedObject = $resource;
    }

    /**
     * Return the number of comments made towards the post.
     *
     * @return integer
     */
    public function getCommentsCount()
    {
        return $this->getWrappedObject()->comments->count();
    }

    /**
     * If there are more than 1 comment made we will return the
     * number of comments. Otherwise return the word 'discuss.'
     *
     * @return int|string
     */
    public function getCommentsCountOrDiscuss()
    {
        return Lang::choice(
            '{0} discuss|[1,1] :count comment|[2,Inf] :count comments',
            $this->getCommentsCount(),
            [
                'count' => $this->getCommentsCount()
            ]
        );
    }

    /**
     * Get the difference in a human readable format for the duration since the post was created.
     *
     * @return string
     */
    public function getDurationSinceCreated()
    {
        return $this->getWrappedObject()->created_at->diffForHumans();
    }

    /**
     * Return the link to the post.
     *
     * @return string
     */
    public function getLinkToPost()
    {
        return route('posts.show', $this->getWrappedObject()->id);
    }

    /**
     * Return the link to the profile of the poster.
     *
     * @return string
     */
    public function getLinkToPostersProfile()
    {
        return route('users.show', $this->getWrappedObject()->user->getUsername());
    }

    /**
     * Return the title of the post.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getWrappedObject()->title;
    }

    /**
     * Return the url of th post.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->getWrappedObject()->url;
    }

    public function getUrlDomain()
    {
        // First we'll need to remove the http:// or https:// from the url.
        //
        $url = preg_replace("(^https?://)", "", $this->getUrl() );

        // Now remove any www from start of the url.
        //
        $url = preg_replace("(^www.)", "", $url);

        // Now capture everything before the first forward slash.
        //
        $url = explode('/', $url);

        // Now return the url.
        //
        return $url[0];
    }

    /**
     * Return the username of the poster.
     *
     * @return string
     */
    public function getUsernameOfPoster()
    {
        return $this->getWrappedObject()->user->getUsername();
    }
} 