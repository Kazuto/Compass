<?php

declare(strict_types=1);

namespace App\Http\Requests\Bookmarks;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateBookmarkGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->can('manage-bookmarks');
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'team_ids' => 'array',
            'team_ids.*' => ['boolean', 'in:0,1'],
        ];
    }
}
