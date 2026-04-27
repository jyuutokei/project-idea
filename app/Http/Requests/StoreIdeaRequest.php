<?php

namespace App\Http\Requests;

use App\IdeaStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIdeaRequest extends FormRequest
{
    /**
    public function authorize(): bool
    {
        return true;
    }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'min:10'],
            'status' => ['sometimes', 'string', Rule::in(array_column(IdeaStatus::cases(), 'value'))],
            'user_id' => ['sometimes', 'integer', 'exists:users,id'],
            'image' => ['nullable', 'image', 'max:5120'],
            'links' => ['sometimes', 'array', 'max:10'],
            'links.*' => ['nullable', 'url', 'max:2048'],
        ];
    }
}
