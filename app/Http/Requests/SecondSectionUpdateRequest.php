<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SecondSectionUpdateRequest extends FormRequest
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
            'name' => ['sometimes', 'required', 'string', 'unique:second_sections,name,' . $this->route('second_section')['id']],
            'birth_date' => ['sometimes', 'required', 'date', 'date_format:Y-m-d'],
            'created_at' => ['sometimes', 'required', 'date'],
        ];
    }
}
