<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class AdminEditPostFormRequest extends Request {

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
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'text.required_if' => 'The :attribute field is required when :other is blank.'
        ];
    }

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
        return [
            'text'  => 'required_if:url,',
            'title' => 'required',
            'url'   => 'url'
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
