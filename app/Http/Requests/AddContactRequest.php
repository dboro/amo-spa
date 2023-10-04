<?php

namespace App\Http\Requests;

use App\Dto\AddContactDto;
use Illuminate\Foundation\Http\FormRequest;

class AddContactRequest extends FormRequest
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
            'leadId' => ['required', 'numeric'],
            'name' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'comment' => ['required', 'string']
        ];
    }

    public function getDto(): AddContactDto
    {
        $data = $this->validated();

        return new AddContactDto(
            $data['leadId'],
            $data['name'],
            $data['phone'],
            $data['comment']
        );
    }
}
