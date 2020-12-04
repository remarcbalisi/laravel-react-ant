<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            /**
             * confirmed
             * The field under validation must have a matching field of foo_confirmation. For example,
             * if the field under validation is password, a matching password_confirmation field must
             * be present in the input.
             */
            'password' => 'required|confirmed',
            'email' => 'required|unique:App\Models\User,email',
            'role' => 'required'
        ];
    }
}
