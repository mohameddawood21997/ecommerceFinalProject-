<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        return [
            'name' => ['required'],
            'email' => 'required|email|unique:users|max:255',
            'password' => ['required'],
            'gender' => ['required'],
            // 'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ];
    }
}
