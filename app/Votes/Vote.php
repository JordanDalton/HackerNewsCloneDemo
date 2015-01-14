<?php namespace App\Votes;

use App\Core\Model;

class Vote extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'votes';

    /**
     * Polymorphic target for submitting votes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function voteable()
    {
        return $this->morphTo();
    }
} 