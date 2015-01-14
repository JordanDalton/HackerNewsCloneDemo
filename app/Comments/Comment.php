<?php namespace App\Comments;

use App\Core\PresentableSoftDeleteModel;
use App\Posts\Post;
use App\Users\User;
use App\Votes\Vote;
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
        return $this->hasMany( static::class, 'parent_id')->with('replies');
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
            DB::raw('(POWER(comments.votes - 1, .8) / POWER(TIMESTAMPDIFF(HOUR, NOW(), comments.created_at) + 2, 1.8)) * comments.penalties as computed_rank')
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
     * Fetch all votes for the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function votes()
    {
        return $this->morphMany( Vote::class, 'voteable');
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
} 