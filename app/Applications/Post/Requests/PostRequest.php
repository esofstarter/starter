<?php

namespace App\Applications\User\Requests;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;


class UserRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // we will handle this with middleware
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $role = $this->request->get('roles'); // Get the input value

        $rules = [
            'first_name' => 'required|max:255|min:2',
            'last_name' => 'required|max:255|min:2',
            'email' => 'required|email|min:2|max:255|unique:users,email,'.$this->segment(3),
            'password' => 'required_with:password_confirmation|nullable|between:6,30|confirmed',
            'password_confirmation' => 'required_with:password|nullable|between:6,30|same:password',
            'roles' => 'required|exists:roles,id',
            'uploaded_file' => 'file|mimes:jpeg,jpg,png,gif|max:30000',
        ];

        return $rules;
    }
    public function messages(){
        return [

        ];
    }
}