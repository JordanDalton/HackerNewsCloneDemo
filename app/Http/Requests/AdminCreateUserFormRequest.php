<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminCreateUserFormRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return Auth::check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'username'  => 'required|unique:users,username',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'min:6|confirmed',
            'restore'   => 'boolean'
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
