<?php

namespace App\Http\Requests\Api\V1\Lecturer;

use App\Enums\TopicStatus;
use Illuminate\Foundation\Http\FormRequest;

class CreateTopicOfferRequest extends FormRequest
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
            'judul' => 'required|string|max:150',
            'deskripsi' => 'required|string|min:150',
            'keywords' => 'required|array|max:5',
            'keywords.*' => 'required|string',
            'prasyarat' => 'nullable|string|max:255',
            'kuota' => 'required|integer|min:0',
            'bidang_id' => 'required|exists:field_taxonomy,id',
            'status' => 'required|in:' . implode(',', array_column(TopicStatus::cases(), 'value')),
        ];
    }
}
