<?php

declare(strict_types=1);

namespace App\Http\Requests\General;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ThemeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->can('manage-theme');
    }

    public function rules(): array
    {
        return [
            'colors' => ['required', 'array', 'size:2', 'required_array_keys:accent,base'],
            'colors.*' => ['required', 'array', 'size:3', 'required_array_keys:light,medium,dark'],
            'colors.*.*' => ['required', 'string', 'min:4', 'max:7', 'starts_with:#'],
        ];
    }
}
