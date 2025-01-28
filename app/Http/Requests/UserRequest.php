<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class UserRequest.
 */
class UserRequest extends Request
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

    public function attributes()
    {
        return [
            'email' => 'Email',
        ];
    }

    public function rules()
    {
        return [
            'name' => 'required|max:155',
            'email' => 'required|email|max:155|unique:users,email,' . $this -> id ,
            'phone' => 'required'
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}
