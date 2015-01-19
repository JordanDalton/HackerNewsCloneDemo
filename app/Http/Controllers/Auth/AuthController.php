<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use App\Users\UserRepositoryInterface;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Session;

class AuthController extends Controller {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * The registrar implementation.
     *
     * @var Registrar
     */
    protected $registrar;

    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard     $auth
     * @param  \Illuminate\Contracts\Auth\Registrar $registrar
     *
     * @return \App\Http\Controllers\Auth\AuthController
     */
    public function __construct( Guard $auth , Registrar $registrar )
    {
        $this->auth      = $auth;
        $this->registrar = $registrar;

        $this->middleware( 'guest' , [ 'except' => ['getEmailVerify', 'getLogout'] ] );
    }


    /**
     * Verify that the email verification link contains a valid activation code.
     *
     * @param string                  $email_authentication_code
     * @param UserRepositoryInterface $userRepository
     *
     * @return Redirect
     */
    public function getEmailVerify( $email_authentication_code , UserRepositoryInterface $userRepository )
    {
        // Check if the activation code matches a user record that has
        // yet to be marked as active.
        //
        $isValid = $userRepository->isValidEmailAuthenticationCode( $email_authentication_code );

        // If the activation code is valid we need to update the user account with
        // a new activation code, as well as mark the account as active.
        if ( $isValid )
        {
            $account = $isValid;

            // Update user account to be active.
            //
            $userRepository->markAccountAsEmailAuthenticated( $account );

            // Log the user into their account.
            //
            Auth::login( $account );

            // Redirect the user to the homepage.
            //
            return redirect( '/' );
        }

        // Redirect the user to the homepage.
        //
        return view( 'errors.invalid_email_authentication_code' );
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return routeView();
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Foundation\Http\FormRequest|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postRegister( Request $request )
    {
        $validator = $this->registrar->validator( $request->all() );

        if ( $validator->fails() )
        {
            $this->throwValidationException(
                $request , $validator
            );
        }

        $this->auth->login( $this->registrar->create( $request->all() ) );

        return redirect( $this->redirectPath() );
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return routeView();
    }

    /**
     * Handle a login request to the application.
     *
     * @param LoginFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin( LoginFormRequest $request )
    {
        $this->validate( $request , [
            'email' => 'required' , 'password' => 'required' ,
        ] );

        $credentials = $request->only( 'email' , 'password' );

        if ( $this->auth->attempt( $credentials , $request->has( 'remember' ) ) )
        {
            // Flush out any roles assignments in the session data.
            //
            Session::forget('is_admin');
            Session::forget('is_moderator');

            return redirect()->intended( $this->redirectPath() );
        }

        return redirect()->back()
            ->withInput( $request->only( 'email' ) )
            ->withErrors( [ 'email' => 'These credentials do not match our records.' ] );
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        $this->auth->logout();

        return redirect( '/' );
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        return property_exists( $this , 'redirectTo' ) ? $this->redirectTo : '/';
    }

}
