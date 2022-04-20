<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCredentialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'type' => ['required', 'in:gitlab'],
            'name' => ['required', 'string'],
            'description' => ['present'],
            'credentials' => ['required', 'array'],
        ];

        $rules += $this->getTypeCredentialsValidation($this->get('type'));

        return $rules;
    }

    private function getTypeCredentialsValidation(string|null $type): array
    {
        return match ($type) {
            'gitlab' => [
                'credentials.accessTokenName' => ['required', 'string'],
                'credentials.accessTokenSecret' => ['required', 'string'],
            ],
            default => []
        };
    }
}
