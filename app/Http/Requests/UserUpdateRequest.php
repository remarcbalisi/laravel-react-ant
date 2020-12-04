<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('update', $this->user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|unique:App\Models\User,email,'.$this->user->id,
            'name' => 'required',
            'whatsapp' => 'required',
            'phone_number' => 'required',
            'role' => Rule::requiredIf(auth()->user()->hasRole('admin'))
        ];
    }
}
