<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Users\UserRepositoryInterface;
use Illuminate\Validation\Factory;

class LoginFormRequest extends Request {

    /**
     * @var \Illuminate\Validation\Factory
     */
    private $factory;

    /**
     * The user repository implementation.
     *
     * @var \App\Users\UserRepositoryInterface
     */
    private $userRepository;

    /**
     * Create new LoginFormRequest instance.
     *
     * @param Factory                 $factory
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct( Factory $factory , UserRepositoryInterface $userRepository )
    {
        $this->factory        = $factory;
        $this->userRepository = $userRepository;

        // We will extend the validation to include our implementation which will check if
        // the user is email verified.
        //
        $factory->extendImplicit('email_authenticated', function($attribute, $value, $parameters)
        {
           return $this->userRepository->byEmailAddressCheckIfAccountIsEmailAuthenticated( $value );
        }, 'Sorry, this account has yet to be email verified. Please check your inbox for verification email.');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'required|email|email_authenticated',
            'password'  => 'required'
        ];
    }

    /**
     * Get the sanitized input for the request.
     *
     * @return array
     */
    public function sanitize()
    {
        return $this->all();
    }
}
