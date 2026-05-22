<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApplicationRequest extends FormRequest
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
            'pet_id' => [
                'required',
                'exists:pets,id',
                // Check if pet is available
                function ($attribute, $value, $fail) {
                    $pet = \App\Models\Pet::find($value);
                    if ($pet && $pet->status !== 'Available') {
                        $fail('This pet is no longer available for adoption.');
                    }
                },
            ],
            'adopter_name' => 'required|string|max:255',
            'contact_number' => 'required|string|regex:/^[0-9\-\+\(\)\s]+$/|min:10|max:20',
            'address' => 'required|string|max:1000',
            'home_background' => 'required|string|max:2000',
            'application_date' => 'required|date|before_or_equal:today',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'pet_id.required' => 'Please select a pet.',
            'pet_id.exists' => 'The selected pet does not exist.',
            'adopter_name.required' => 'Your full name is required.',
            'adopter_name.max' => 'Your name must not exceed 255 characters.',
            'contact_number.required' => 'Contact number is required.',
            'contact_number.regex' => 'Please enter a valid phone number.',
            'contact_number.min' => 'Contact number must be at least 10 digits.',
            'address.required' => 'Your home address is required.',
            'home_background.required' => 'Please tell us about your home background.',
            'application_date.required' => 'Application date is required.',
            'application_date.date' => 'Please enter a valid date.',
            'application_date.before_or_equal' => 'Application date cannot be in the future.',
        ];
    }
}
