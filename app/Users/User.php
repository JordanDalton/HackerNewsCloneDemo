<?php namespace App\Users;

use App\Core\PresentableSoftDeleteModel;
use App\Roles\Role;
use Auth;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Hash;
use Illuminate\Database\Eloquent\Builder;

class User extends PresentableSoftDeleteModel implements AuthenticatableContract , CanResetPasswordContract {

    use Authenticatable , CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [ 'email_authenticated_at' ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'about' , 'email' , 'password', 'username'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ 'password' , 'remember_token' ];

    /**
     * Define which fields we will allowed to be searched.
     *
     * @var array
     */
    protected $searchable_fields = ['about', 'email', 'username'];

    /**
     * Decrement the users karma score.
     *
     * @return bool
     */
    public function decrementKarma()
    {
        // Increment the karma score.
        //
        $this->karma = $this->karma -1;

        // Now save the changes.
        //
        return $this->save();
    }

    /**
     * Generate a unique email authentication code.
     *
     * @return string
     */
    public function generateUniqueEmailAuthenticationCode()
    {
        return $this->generateUnique( 'email_authentication_code' );
    }

    /**
     * Find out if the user has a specific role
     *
     * @param $check
     *
     * @return bool
     */
    public function hasRole( $check )
    {
        return in_array( $check , array_fetch( $this->roles->toArray() , 'name' ) );
    }

    /**
     * Increment the users karma score.
     *
     * @return bool
     */
    public function incrementKarma()
    {
        // Increment the karma score.
        //
        $this->karma = $this->karma + 1;

        // Now save the changes.
        //
        return $this->save();
    }

    /**
     * Check if the user is not the account holder.
     *
     * @return boolean
     */
    public function isNotAccountHolder()
    {
        return $this->isAccountHolder() == FALSE;
    }

    /**
     * Check if the user in session is the user account holder.
     *
     * @return bool
     */
    public function isAccountHolder()
    {
        if( ! Auth::check() )
        {
            return false;
        }

        return $this->id == Auth::id();
    }


    /**
     * Return the user presenter class.
     *
     * @return UserPresenter
     */
    public function present()
    {
        $presenterClassName = $this->getPresenterClass();

        return new $presenterClassName($this);
    }

    /**
     * Return all the roles that the user is assigned/belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany( Role::class , 'user_role' );
    }

    /**
     * Query scope that will look for records that have the
     * active field marked with a 1.
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function scopeActive( $query )
    {
        return $query->whereActive( 1 );
    }

    /**
     * Query scope that will fetch records that fall within
     * a provided search criteria.
     *
     * @param Builder $query
     * @param array   $search_parameters
     *
     * @return $this
     */
    public function scopeCriteria( Builder $query, $search_parameters )
    {
        // Define a list of allowable search fields.
        //
        $search_parameters = $this->searchableFields( $search_parameters );

        return $query->where( function( $query ) use( $search_parameters )
        {
            // Drop any array that have blank values.
            //
            $search_parameters = dropBlankArrayValues($search_parameters);

            // Iterate through the list of $likeField and generate
            // a like statement for each.
            //
            foreach( $search_parameters as $field => $search_value )
            {
                $query->orWhere($field, 'like', "%$search_value%");
            }
        });
    }

    /**
     * Query scope that will look for records that have the
     * active field marked with a 0.
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function scopeInactive( $query )
    {
        return $query->whereActive( 0 );
    }

    /**
     * Query scope will fetch accounts that are not banned.
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     *
     * @return mixed
     */
    public function scopeUnbanned( $query )
    {
        return $query->whereHas( 'roles' , function ( $query )
        {
            return $query->whereNotIn( 'name' , [ 'Banned' ] );
        });
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
     * Automatically hash passwords.
     *
     * @param string $password
     */
    public function setPasswordAttribute( $password )
    {
        $this->attributes[ 'password' ] = Hash::make( $password );
    }
}
