<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotifRequest extends FormRequest
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
            'sender' => ['required', 'string','max:255'],
            'receiver' => ['required', 'string','max:255'],
            'type' => ['required', 'string','max:255'],
            'model' => ['required', 'string','max:255'],
            'content' => ['required'],
        ];
    }
}
