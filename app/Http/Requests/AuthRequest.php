<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/* @property-read string $provider */
class AuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guest();
    }

    public function rules(): array
    {
        return [
            'provider' => ['in:github'],
        ];
    }
}
