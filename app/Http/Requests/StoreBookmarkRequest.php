<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookmarkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
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
