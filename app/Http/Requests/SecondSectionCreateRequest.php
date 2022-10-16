<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SecondSectionCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:second_sections,name'],
            'birth_date' => ['required', 'date', 'date_format:Y-m-d'],
            'created_at' => ['required', 'date'],
        ];
    }
}
