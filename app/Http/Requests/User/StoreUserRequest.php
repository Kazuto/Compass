<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->can('manage-users');
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'username' => [Rule::unique('users')],
            'email' => [Rule::unique('users')],
            'password' => ['required', 'min:8', 'same:confirm_password'],
            'confirm_password' => ['required', 'min:8', 'same:password'],
            'is_admin' => ['boolean', 'in:0,1'],
        ];
    }
}
