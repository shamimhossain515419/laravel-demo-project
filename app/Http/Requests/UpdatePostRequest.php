<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePostRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255', // Optional but required if provided
            'body' => 'sometimes|required|string',           // Optional but required if provided
            'category_id' => 'sometimes|required|exists:categories,id', // Optional but required if provided
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required when provided.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'body.required' => 'The body field is required when provided.',
            'body.string' => 'The body must be a string.',
            'category_id.required' => 'The category ID field is required when provided.',
            'category_id.exists' => 'The selected category ID does not exist.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        // Customize the JSON response for validation failure
        $response = response()->json([
            'status' => false,
            'message' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
