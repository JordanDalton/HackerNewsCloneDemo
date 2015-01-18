<?php namespace App\Roles;

use App\Core\PresentableSoftDeleteModel;
use App\Users\User;

class Role extends PresentableSoftDeleteModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'core',
        'name',
    ];

    /**
     * Return if the role is a "core" role.
     *
     * @return bool
     */
    public function isCore()
    {
        return (boolean) $this->core;
    }

    /**
     * Return if the role is not a "core" role."
     *
     * @return bool
     */
    public function isNotCore()
    {
        return ! $this->isCore();
    }

    /**
     * Query scope that will fetch records that fall within
     * a provided search criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param string $criteria
     */
    public function scopeCriteria( $query, $criteria )
    {
        return $query->where( function( $query ) use( $criteria )
        {
            // Define a list of fields we want to search within.
            //
            $likeFields = ['name'];

            // Iterate through the list of $likeField and generate
            // a like statement for each.
            //
            foreach( $likeFields as $field )
            {
                $query->orWhere($field, 'like', "%$criteria%");
            }
        });
    }

    /**
     * Query scope that prevent core roles from being fetched.
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeNonCore( $query  )
    {
        return $query->whereCore(false);
    }

    /**
     * Return all the users that are assigned/belongs-to the role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany( User::class , 'user_role' );
    }
} 