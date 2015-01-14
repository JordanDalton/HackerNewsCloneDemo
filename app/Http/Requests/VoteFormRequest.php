<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

/**
 * We're essentially using this to validate that the user is logged in. We chose to create this request form
 * in case you wanted to extend this behavior.
 *
 * Class VoteFormRequest
 * @package App\Http\Requests
 */
class VoteFormRequest extends Request {

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
			//
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
