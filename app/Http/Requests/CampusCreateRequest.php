<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CampusCreateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // ─── Campus Fields ───────────────────────────────────────────
            'name' => ['required', 'string', 'max:255'],

            'country' => ['required', 'string', 'max:100'],

            'city' => ['required', 'string', 'max:100'],

            'address' => ['nullable', 'string', 'max:1000'],

            'phone' => ['nullable', 'string', 'max:30'],

            'campus_email' => ['nullable', 'email', 'max:150'],

            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp,svg',
                'max:2048',
            ],

            // currency & timezone are optional — model/DB defaults apply (GBP, Europe/London)
            'currency' => ['nullable', 'in:GBP,BDT,USD'],

            'timezone'  => ['nullable', 'string', 'max:50'],

            'status' => ['required', 'in:active,inactive'],

            // ─── Campus Head (Admin User) Fields ─────────────────────────
            'user_first_name'  => ['required', 'string', 'max:100'],
            'user_middle_name' => ['nullable', 'string', 'max:100'],
            'user_last_name'   => ['required', 'string', 'max:100'],
            'user_email'       => ['required', 'email', 'max:255', 'unique:users,email'],
            'user_phone'       => ['nullable', 'string', 'max:30'],
            'password'         => ['required', 'string', 'min:8'],
        ];
    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [

            'campus_code.required' => 'Campus code is required.',
            'campus_code.unique' => 'This Campus code already exists.',

            'name.required' => 'Campus name is required.',

            'country.required' => 'Country is required.',

            'city.required' => 'City is required.',

            'currency.required' => 'Currency is required.',
            'currency.in' => 'Selected currency is invalid.',

            'timezone.required' => 'Timezone is required.',

            'status.required' => 'Status is required.',

            'logo.image' => 'Logo must be an image file.',
            'logo.max' => 'Logo size must not exceed 2MB.',
        ];
    }

    /**
     * Friendly Attribute Names
     */
    public function attributes(): array
    {
        return [
            'campus_code' => 'campus code',
            'short_name' => 'short name',
        ];
    }
}
