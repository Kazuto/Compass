<?php

declare(strict_types=1);

namespace App\Http\Requests\WhitelistAccess;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreWhitelistAccessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->can('manage-whitelist-access');
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }
}
