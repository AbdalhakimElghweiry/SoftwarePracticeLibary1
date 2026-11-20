<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name"        => "sometimes|string",
            "author"      => "sometimes|string",
            "ISBN"        => ["sometimes", Rule::unique("books", "ISBN")->ignore($this->route("book"))],
            "category_id" => "sometimes|exists:categories,id",
        ];
    }
}
