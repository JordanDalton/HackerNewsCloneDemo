<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class CommentFormRequest extends Request {

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
			'comment'   => 'required',
            'parent_id' => 'exists:comments,parent_id',
            'post_id'   => 'required|exists:posts,id'
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
