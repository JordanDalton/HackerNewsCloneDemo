<?php namespace App\Users;

use App\Core\PresentableSoftDeleteModel;
use App\Roles\Role;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Hash;

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
    protected $fillable = [ 'about' , 'name' , 'email' , 'password' ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ 'password' , 'remember_token' ];

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
     * @param $query
     * @return mixed
     */
    public function scopeActive( $query )
    {
        return $query->whereActive( 1 );
    }

    /**
     * Query scope that will look for records that have the
     * active field marked with a 0.
     *
     * @param $query
     * @return mixed
     */
    public function scopeInactive( $query )
    {
        return $query->whereActive( 0 );
    }

    /**
     * Query scope will fetch accounts that are not banned.
     *
     * @param $query
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
     * Automatically hash password.
     *
     * @param string $password
     */
    public function setPasswordAttribute( $password )
    {
        $this->attributes[ 'password' ] = Hash::make( $password );
    }
}
