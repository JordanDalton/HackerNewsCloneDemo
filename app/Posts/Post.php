<?php namespace App\Posts;

use App\Comments\Comment;
use App\Core\PresentableSoftDeleteModel;
use App\Users\User;
use App\Votes\Vote;
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
        'text',
        'title',
        'url'
    ];

    /**
     * Calculate the ran for a given post.
     *
     * @param $votes
     * @param $age
     * @param $penalties
     *
     * @return float
     */
    public function calculateRank($votes, $age, $penalties)
    {
        return (pow($votes - 1, .8) / pow($age + 2, 1.8)) * $penalties;
    }

    /**
     * Return all comments made towards the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany( Comment::class )->ranked();
    }

    /**
     * Return all comments that are made directory towards the creator
     * of the post, not replies to comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parentComments()
    {
        return $this->comments()->whereNull('parent_id');
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
        return $query->whereAsk(true);
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
            DB::raw('(POWER(posts.votes - 1, .8) / POWER(TIMESTAMPDIFF(HOUR, NOW(), posts.created_at) + 2, 1.8)) * posts.penalties as computed_rank')
        ])->orderBy('computed_rank', 'DESC');
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
        return $query->whereShow(true);
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
        return $this->morphMany( Vote::class, 'voteable');
    }
} 