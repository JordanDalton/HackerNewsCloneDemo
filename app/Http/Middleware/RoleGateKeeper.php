<?php namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\Middleware;

class RoleGatekeeper implements Middleware {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     *
     * @return \App\Http\Middleware\RoleGatekeeper
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Capture the user object.
        //
        $user = $this->auth->user();

        // Capture route information.
        //
        $route = $request->route();

        // Process if both $user and $route have data.
        //
        if ( $user AND $route AND array_key_exists('roles', $route->getAction()))
        {
            // Separate each role.
            //
            $roles = $route->getAction()['roles'];

            // Counter/flag which represents if the user is allowed to proceed. By default
            // we will return 0 (false)
            //
            $allowed = 0;

            // We we will loop through the list of $roles and will check
            // if the user is assigned to the role. If the user is not
            // assigned to the role we will abort and sent the user
            // to the homepage.
            //
            foreach( $roles as $role )
            {
                // If the user is allowed we will increment the allowed counter.
                //
                if ( $user->hasRole($role) )
                {
                    $allowed = true;
                }
            }

            // By default we will not allow users that have been banned.
            //
            if( $user->hasRole('Banned') )
            {
                $allowed = false;
            }

            // If the user is allowed we will proceed onto the next filter/middleware.
            //
            if ( $allowed )
            {
                return $next( $request );
            }
        }

        // If ajax request show json response.
        //
        if( $request->ajax() )
        {
            // Response message.
            //
            $response = [
                'error'     => '403',
                'message'   => "You do not have permission to access the page you were requesting."
            ];

            return response()->make($response, 403);
        }

        // Redirect the user to the permissions denied page.
        //
        return response()->make(view('errors.403'), 403);
    }

}
