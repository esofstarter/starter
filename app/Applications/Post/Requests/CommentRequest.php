<?php

namespace App\Applications\Post\Requests;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;


class CommentRequest extends ApiFormRequest
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
            'comment' => 'required|max:255|min:2',
            'id' => 'required',
            // 'user_id' => 'required',
            // 'password_confirmation' => 'required_with:password|nullable|between:6,30|same:password',
            // 'roles' => 'required|exists:roles,id',
            // 'uploaded_file' => 'file|mimes:jpeg,jpg,png,gif|max:30000',
        ];

        return $rules;
    }
    public function messages(){
        return [
            'comment.required' => 'Comment is missing.',
            'comment.max' => 'Comment is too long.',
            'comment.min' => 'Comment is too short.',
            'id.required' => 'Comment id is missing.',
//            'user_id.required' => 'User id is missing.'
        ];
    }
}
