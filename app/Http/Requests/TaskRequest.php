<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'    => 'required|string|min:1|max:255',
            'detail'   => 'nullable|string|max:5000',
            'board_id' => 'required|integer',
            'order'    => 'nullable|integer'
        ];
    }
}
