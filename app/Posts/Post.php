<?php namespace App\Posts;

use App\Comments\Comment;
use App\Core\PresentableSoftDeleteModel;
use App\Users\User;
use App\Votes\Vote;
use Auth;
use Carbon\Carbon;
use DB;

class Post extends PresentableSoftDeleteModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text' ,
        'title' ,
        'url'
    ];

    /**
     * Define a list of fields which we will ignore a asterisk value.
     *
     * @var array
     */
    protected $fields_to_ignore_asterisk = ['ask', 'show'];

    /**
     * Define a list of fields which we will ignore values of zero (0).
     *
     * @var array
     */
    protected $fields_to_ignore_zeros = ['user_id'];

    /**
     * Define which fields we will allowed to be searched.
     *
     * @var array
     */
    protected $searchable_fields = ['ask', 'show', 'text', 'title', 'url', 'user_id'];

    /**
     * Return all comments made towards the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany( Comment::class )->ranked()->byUnbannedUser();
    }

    /**
     * Return all comments that are made directory towards the creator
     * of the post, not replies to comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parentComments()
    {
        return $this->comments()->whereNull( 'parent_id' );
    }

    /**
     * Query scope that will fetch records where the ask column is equal to 1 (true).
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeAsk( $query )
    {
        return $query->whereAsk( true );
    }

    /**
     * Query scope that will filter out records where the user is banned.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeByUnbannedUser( $query )
    {
        return $query->whereHas( 'user' , function ( $query )
        {
            return $query->unbanned();
        } );
    }

    /**
     * Query scope that will fetch records that fall within
     * a provided search criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param array $search_parameters
     */
    public function scopeCriteria( $query, $search_parameters = [] )
    {
        // Define a list of allowable search fields.
        //
        $search_parameters = $this->searchableFields( $search_parameters );

        return $query->where( function( $query ) use( $search_parameters )
        {
            // Drop any array that have blank values.
            //
            $search_parameters = dropBlankArrayValues($search_parameters);

            // Iterate through the list of $search_parameters and generate
            // a like statement for each.
            //
            foreach( $search_parameters as $field => $field_value )
            {
                // Ignore fields with * as the value.
                //
                if( in_array($field, $this->fields_to_ignore_asterisk) && $field_value === '*') continue;

                // Ignore fields with 0 as the value.
                //
                if( in_array($field, $this->fields_to_ignore_zeros) && $field_value == 0) continue;

                // Otherwise we will apply the filter to the query.
                //
                $query->where($field, 'like', "%$field_value%");
            }
        });
    }

    /**
     * Query scope that will order results by ranking.
     *
     * @param $query
     */
    public function scopeRanked( $query )
    {
        return $query->select( [
            '*' ,
            DB::raw( '(POWER(posts.votes, .8) / POWER(CAST((TIMESTAMPDIFF(HOUR, NOW(), posts.created_at) + 2) AS unsigned), 1.8)) * posts.penalties AS computed_rank' )
        ] )->orderBy( 'computed_rank' , 'DESC' );
    }

    /**
     * Query scope that will fetch records where the show column is equal to 1 (true).
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeShow( $query )
    {
        return $query->whereShow( true );
    }

    /**
     * Define query scope that will only fetch today's records.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeToday( $query )
    {
        return $query->where('created_at', '>', Carbon::today());
    }

    /**
     * Return a list of user fields that are allowed to be searched upon.
     *
     * @param array $requested_fields
     *
     * @return array
     */
    public function searchableFields( $requested_fields = [] )
    {
        // Ignore any fields that we are not allowing to be searched.
        //
        return array_only($requested_fields, $this->searchable_fields);
    }

    /**
     * Return the record of the user that submitted the item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo( User::class );
    }

    /**
     * Fetch all votes for the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function votes()
    {
        return $this->morphMany( Vote::class , 'voteable' );
    }

    /**
     * Fetch all the votes by the logged in user.
     *
     * @return mixed
     */
    public function votedByLoggedInUser()
    {
        return (boolean) $this->votes()->whereUserId( Auth::check() ? Auth::id() : 0 )->count();
    }
} 