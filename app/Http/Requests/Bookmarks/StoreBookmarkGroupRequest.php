<?php

declare(strict_types=1);

namespace App\Http\Requests\Bookmarks;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBookmarkGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'team_ids' => 'array',
        ];
    }
}
