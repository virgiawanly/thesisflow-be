<?php

namespace App\Http\Requests\Api\V1\SystemAdmin\FieldTaxonomy;

use Illuminate\Foundation\Http\FormRequest;

class CreateFieldTaxonomyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:80|unique:field_taxonomy,nama',
            'parent_id' => 'nullable|exists:field_taxonomy,id',
        ];
    }
}
