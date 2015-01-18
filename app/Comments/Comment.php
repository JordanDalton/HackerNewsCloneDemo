<?php namespace App\Comments;

use App\Core\PresentableSoftDeleteModel;
use App\Posts\Post;
use App\Users\User;
use App\Votes\Vote;
use Auth;
use DB;

class Comment extends PresentableSoftDeleteModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['comment', 'post_id', 'parent_id'];

    /**
     * Return all reply comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany( static::class, 'parent_id' )->with('replies');
    }

    /**
     * Query scope that will order results by ranking.
     *
     * @param $query
     */
    public function scopeRanked( $query )
    {
        return $query->select([
            '*',
            DB::raw('(POWER(comments.votes, .8) / POWER(CAST((TIMESTAMPDIFF(HOUR, NOW(), comments.created_at) + 2) AS unsigned), 1.8)) * comments.penalties AS computed_rank')
        ])->orderBy('computed_rank', 'DESC');
    }

    /**
     * Return the post that the comment was made towards.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo( Post::class );
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
        return $query->where( function( $query ) use( $search_parameters )
        {
            // Iterate through the list of $search_parameters and generate
            // a like statement for each.
            //
            foreach( $search_parameters as $field => $field_value )
            {
                // Ignore user_id with * as the value.
                //
                if( $field === 'user_id' && $field_value === '*') continue;

                $query->where($field, 'like', "%$field_value%");
            }
        });
    }

    /**
     * Return the record of the user that made the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo( User::class );
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
     * Fetch all the votes by the logged in user.
     *
     * @return mixed
     */
    public function votedByLoggedInUser()
    {
        return (boolean) $this->votes()->whereUserId( Auth::check() ? Auth::id() : 0 )->count();
    }

    /**
     * Fetch all votes for the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function votes()
    {
        return $this->morphMany( Vote::class, 'voteable');
    }
} 