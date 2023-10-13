<?php

declare(strict_types=1);

namespace App\Http\Requests\Bookmarks;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBookmarkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->can('manage-bookmarks');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'url' => 'required|url',
            'icon' => 'string',
            'order' => 'integer',
            'bookmark_group_id' => 'required|integer',
        ];
    }
}
