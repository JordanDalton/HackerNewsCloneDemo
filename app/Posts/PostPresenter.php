<?php namespace App\Posts;

use App\Core\BasePresenter;
use Config;
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
     * Return the id number of the post.
     *
     * @return int
     */
    public function getId()
    {
        return $this->getWrappedObject()->id;
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
     * Return the url to the post.
     *
     * @return string
     */
    public function getPostUrl()
    {
        return $this->hasUrl() ? $this->getUrl() : $this->getLinkToPost();
    }

    /**
     * Return the title of the post.
     *
     * @return string
     */
    public function getTitle()
    {
        $prefix = '';

        switch(true)
        {
            case $this->isQuestion(): $prefix = Config::get('settings.ask_title_prefix');  break;
            case $this->isShow():     $prefix = Config::get('settings.show_title_prefix'); break;
        }

        return $prefix . $this->getWrappedObject()->title;
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

    /**
     * Return the base domain of the url that was submitted.
     *
     * @return string
     */
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
     * Return the post text.
     *
     * @param  bool $raw Return the raw response.
     * @return mixed
     */
    public function getText( $raw = false )
    {
        // Obtain the text from the record.
        //
        $text = $this->getWrappedObject()->text;

        // If $raw = true we will return the raw text.
        //
        // Otherwise we will return it in a manner to where each new line
        // will become a <br>. We will also prevent the <br> from being
        // stripped out.
        //
        // This is what you would edit should you want additional tags such
        // as links to be shown.
        //
        return $raw ? $raw : strip_tags( nl2br( $text ), '<br>');
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
        return route('posts.vote', $this->getWrappedObject()->id);
    }

    /**
     * Does the post have a URL?
     *
     * @return bool
     */
    public function hasUrl()
    {
        return (bool) $this->getWrappedObject()->url;
    }

    /**
     * Does the post contain text?
     *
     * @return bool
     */
    public function hasText()
    {
        return (bool) $this->getWrappedObject()->text;
    }

    /**
     * Return if the post is a site the user wants to show.
     *
     * @return boolean
     */
    public function isShow()
    {
        return $this->getWrappedObject()->show;
    }

    /**
     * Return is the post is a question.
     *
     * @return mixed
     */
    public function isQuestion()
    {
        return $this->getWrappedObject()->ask;
    }
} 