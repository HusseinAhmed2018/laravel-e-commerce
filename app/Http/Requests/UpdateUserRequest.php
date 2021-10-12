<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $id         = Auth::id();

        return [
            'name'      => ['required','string','min:8','max:255'],
            'email'     => ['required', 'string','email','unique:users,email,' . $id . ',id'],
        ];
    }
}
