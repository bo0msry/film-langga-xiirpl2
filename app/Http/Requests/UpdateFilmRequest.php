<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFilmRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'sinopsis' => ['required', 'string'],
            'year' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 5)],
            'poster' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'genre_id' => ['required', 'exists:genres,id'],
        ];
    }
}

