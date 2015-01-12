<?php namespace App\Comments;

use App\Core\PresentableSoftDeleteModel;
use App\Posts\Post;
use App\Users\User;

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
    protected $fillable = ['comment'];

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
     * Return the record of the user that made the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo( User::class );
    }
} 