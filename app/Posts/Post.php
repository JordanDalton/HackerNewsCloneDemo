<?php namespace App\Posts;

use App\Comments\Comment;
use App\Core\PresentableSoftDeleteModel;
use App\Users\User;

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
     * Return all comments made towards the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany( Comment::class );
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
} 