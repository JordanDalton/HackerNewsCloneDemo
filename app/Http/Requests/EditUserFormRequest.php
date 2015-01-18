<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Users\UserRepositoryInterface;
use Auth;
use App;

class EditUserFormRequest extends Request {

    /**
     * The user repository implementation.
     *
     * @var App\Users\UserRepositoryInterface
     */
    private $userRepository;

    /**
     * Create new EditUserFormRequest
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct( UserRepositoryInterface $userRepository )
    {
        $this->userRepository = $userRepository;
    }

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        // Fetch the user from the database.
        //
        $user = $this->fetchRecord();

        // The user must be logged in, the user record must exist, and the
        // user trying to edit the record must be the account holder.
        //
        return Auth::check() && $user && $user->isAccountHolder();
	}

    /**
     * Fetch the user record from the database.
     *
     * @return mixed
     */
    public function fetchRecord()
    {
        // Fetch the user record from the database.
        //
        return $this->userRepository->simplyFindByUsername( $this->segment(2) );
    }

    /**
     * Override the forbidden response.
     *
     * @return \Illuminate\Http\Response|void'
     */
    public function forbiddenResponse()
    {
        return App::abort('403', 'Unauthorized action.');
    }

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'username'  => 'required|unique:users,username,'    . Auth::id(),
            'email'     => 'required|email|unique:users,email,' . Auth::id(),
            'password'  => 'min:6|confirmed'
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
