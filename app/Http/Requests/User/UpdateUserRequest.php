<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->can('manage-users');
    }

    public function rules(): array
    {
        $user = request()->route()->parameter('user');

        return [
            'name' => ['required'],
            'username' => ['required', Rule::unique('users')->ignore($user->id, 'id')],
            'email' => ['required', Rule::unique('users')->ignore($user->id, 'id')],
            'is_admin' => ['boolean', 'in:0,1'],
        ];
    }
}
