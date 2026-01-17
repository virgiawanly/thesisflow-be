<?php

namespace App\Http\Requests\Api\V1\SystemAdmin\FieldTaxonomy;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFieldTaxonomyRequest extends FormRequest
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
        $fieldTaxonomyId = app('router')->current()->parameter('field_taxonomy');

        return [
            'nama' => 'sometimes|string|max:80|unique:field_taxonomy,nama,' . $fieldTaxonomyId,
            'parent_id' => 'nullable|exists:field_taxonomy,id|not_in:' . $fieldTaxonomyId,
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'parent_id.not_in' => 'A field taxonomy cannot be its own parent.',
        ];
    }
}
