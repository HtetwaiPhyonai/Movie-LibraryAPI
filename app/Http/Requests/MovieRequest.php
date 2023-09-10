<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'summary' => 'required|string',
            'cover_image' => 'required|image|mimes:jpeg,png',
            'genres' => 'required|string',
            'author' => 'required|string',
            'tags' => 'required|string',
            'imdb_rating' => 'required|between:1,5',
            'pdf_download_link' => 'required|url',
        ];
    }
    
}


