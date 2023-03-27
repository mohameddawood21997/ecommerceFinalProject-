<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
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
        // $userId = auth()->user()->id;
        return [
            'name' => ['required'],
            'email' => ['required','email',$this->id
            // Rule::unique('users')->ignore($userId)
        ],
            'gender' => ['required'],
            'image' => ['required'],
        ];
    }
    // 'name' => 'required|string|max:255',
    // 'email' => 'required|email|unique:users,email',
    // 'password' => 'required|string|min:8|max:255|confirmed',


//     public function createUser(MyValidationRequest $request)
// {
//     // The request data is already validated at this point
//     $name = $request->input('name');
//     $email = $request->input('email');
//     $password = $request->input('password');

//     // Your logic to create a new user
// }

public function response(array $errors)
{
    return response()->json([
        'status' => 'error',
        'message' => 'Validation errors',
        'errors' => $errors
    ], 422);
}



}
