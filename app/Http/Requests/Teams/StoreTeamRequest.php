<?php

declare(strict_types=1);

namespace App\Http\Requests\Teams;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->can('manage-teams');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
        ];
    }
}
