<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoardRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:1|max:255',
            'order' => 'nullable|integer'
        ];
    }
}
