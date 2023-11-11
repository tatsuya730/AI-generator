<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // 今回は使用しないのでtrueを返す
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rule = [
            'title' => 'required|string|max:50',
            'body' => 'required|string|max:20000',
        ];

        if ($this->file('image')) {
            $rule['image'] = 'required|file|image|mimes:jpg,png';
        }

        return $rule;
    }
}
