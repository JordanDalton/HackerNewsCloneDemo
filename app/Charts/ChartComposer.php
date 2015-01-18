<?php namespace App\Charts;

use App\Comments\CommentRepositoryInterface;
use App\Posts\PostRepositoryInterface;
use App\Roles\RoleRepositoryInterface;
use App\Votes\VoteRepositoryInterface;
use Carbon\Carbon;

class ChartComposer {

    /**
     * The roles repository implementation.
     *
     * @var App\Roles\RolesRepository
     */
    protected $roles;

    /**
     * The posts repository implementation.
     *
     * @var \App\Posts\PostRepositoryInterface
     */
    protected $posts;

    /**
     * The vote repository interface.
     *
     * @var \App\Votes\VoteRepositoryInterface
     */
    protected $votes;

    /**
     * The comment repository interface.
     *
     * @var \App\Comments\CommentRepositoryInterface
     */
    protected $comments;

    /**
     * Create new RoleComposer instance.
     *
     * @param \App\Roles\RoleRepositoryInterface       $roles
     * @param \App\Posts\PostRepositoryInterface       $posts
     * @param \App\Votes\VoteRepositoryInterface       $votes
     * @param \App\Comments\CommentRepositoryInterface $comments
     */
    function __construct(
        RoleRepositoryInterface $roles,
        PostRepositoryInterface $posts,
        VoteRepositoryInterface $votes,
        CommentRepositoryInterface $comments
    )
    {
        $this->roles    = $roles;
        $this->posts    = $posts;
        $this->votes    = $votes;
        $this->comments = $comments;
    }

    /**
     * Compose the view.
     *
     * @param $view
     */
    public function compose( $view )
    {
        $view->with('role_stats', $this->getRoleStats());
        $view->with('posts_count', $this->getTodaysPostsCount());
        $view->with('day_names_for_last_seven_days', $this->getDayNamesForLastSevenDays());
        $view->with('comment_count_for_last_seven_days', $this->getCommentCountOverSevenDays());
        $view->with('vote_count_for_last_seven_days', $this->getVoteCountOverSevenDays());

    }

    /**
     * Obtain the number of comments between two dates.
     *
     * @param $start_datetime
     * @param $end_datetime
     *
     * @return mixed
     */
    public function getCommentCountBetweenDates( $start_datetime, $end_datetime )
    {
        return $this->comments->getCountBetweenDates( $start_datetime, $end_datetime );
    }

    /**
     * Compile the comment count over the last 7 days.
     *
     * @return string
     */
    public function getCommentCountOverSevenDays()
    {
        $counts = [];

        foreach($this->getDatesForLastSevenDays() as $day)
        {
            $counts[] = $this->getCommentCountBetweenDates( $day['start_datetime'], $day['end_datetime']);
        }

        return json_encode($counts);
    }

    /**
     * Return the day names for the last seven days.
     *
     * @return string
     */
    public function getDayNamesForLastSevenDays()
    {
        $day_names = [];

        foreach( $this->getDatesForLastSevenDays() as $day )
        {
            $day_names[] = $day['name']; //$day['start_datetime'];
        }

        //$day_names = array_reverse($day_names, true);

        return json_encode(array_values($day_names));
    }

    /**
     * Return start/end date time for the last 7 days.
     *
     * @return array
     */
    public function getDatesForLastSevenDays()
    {
        // Start with today's date time.
        //
        $today = Carbon::today()->addDay(1);

        // This will contain all of the dates we plan to use.
        //
        $dates = [];

        // We will make up to 7 iterations.
        //
        foreach(range(1, 7) as $iteration)
        {
            $start = $today->subDays(1);

            // Built a list of start and end date times.
            //
            $dates[] = [
                'name'           => $start->format('l'),
                'start_datetime' => $start->startOfDay()->toDateTimeString(),
                'end_datetime'   => $start->endOfDay()->toDateTimeString(),
            ];
        }

        // Comment this line out of you want it to display from left to right
        // start with todays date and working it's way back.
        //
        $dates = array_reverse($dates, true);

        // Return the data.
        //
        return $dates;
    }

    /**
     * Compile today's posts counts.
     *
     * @return string
     */
    public function getTodaysPostsCount()
    {
        $compile = [
            [
                'name' => 'Ask HNC',
                'data' => [$this->getTodaysAskPostsCount()]
            ],
            [
                'name' => 'Show HNC',
                'data' => [$this->getTodaysShowPostsCount()]
            ]
        ];

        return json_encode($compile);
    }

    /**
     * Compiles today's Ask HNC post count.
     *
     * @return array
     */
    public function getTodaysAskPostsCount()
    {
        return $this->posts->getTodaysAskPostCount();
    }

    /**
     * Compiles today's Show HNC post post count.
     *
     * @return array
     */
    public function getTodaysShowPostsCount()
    {
        return $this->posts->getTodaysShowPostCount();
    }

    /**
     * Compile the role statistics.
     *
     * @return array
     */
    public function getRoleStats()
    {
        $role_stats = [];

        foreach( $this->roles->getRolesWithCounts() as $role )
        {
            $role_stats[] = [$role->name, $role->users->count()];
        }

        return json_encode($role_stats);
    }

    /**
     * Obtain the number of votes between two dates.
     *
     * @param $start_datetime
     * @param $end_datetime
     *
     * @return mixed
     */
    public function getVoteCountBetweenDates( $start_datetime, $end_datetime )
    {
        return $this->votes->getCountBetweenDates( $start_datetime, $end_datetime );
    }

    /**
     * Compile the vote count over the last 7 days.
     *
     * @return string
     */
    public function getVoteCountOverSevenDays()
    {
        $counts = [];

        foreach($this->getDatesForLastSevenDays() as $day)
        {
            $counts[] = $this->getVoteCountBetweenDates( $day['start_datetime'], $day['end_datetime']);
        }

        return json_encode($counts);
    }
} 