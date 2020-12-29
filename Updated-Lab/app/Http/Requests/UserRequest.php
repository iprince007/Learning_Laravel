<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'ename' => 'required|min:3',
        ];
    }

    public function messages(){
        return [
            'ename.required'=> "can't left empty....",
            'ename.min'=> "must be at least 3 ch...."
        ];
    }
}