<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'firstName' => ['required', 'string', 'min:1','max:255'],
            'lastName'  => ['required', 'string', 'min:1','max:255'],
            'phone'      => ['required', 'string','unique:users,phone'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
