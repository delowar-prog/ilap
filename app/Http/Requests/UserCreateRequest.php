<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    /**
     * Authorization check
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('User Add');
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'user_first_name'  => ['required', 'string', 'max:100'],
            'user_middle_name' => ['nullable', 'string', 'max:100'],
            'user_last_name'   => ['required', 'string', 'max:100'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'photo'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'campus_id'  => ['required', 'exists:campuses,id'],
            'role'       => ['required', 'exists:roles,name'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
            'status'     => ['required', 'in:active,inactive'],
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'role.exists'       => 'The selected role is invalid.',
            'campus_id.exists'  => 'The selected campus is invalid.',
            'password.confirmed'=> 'Password confirmation does not match.',
            'photo.image'       => 'Please upload a valid image file (jpg, jpeg, png, webp).',
        ];
    }

    /**
     * Additional multi-campus & role validation checks
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $currentUser = auth()->user();
            
            // Security check 1: Non-Super Admin users can only create users for their own campus
            if (!$currentUser->hasRole('Super Admin')) {
                if ($this->campus_id != $currentUser->campus_id) {
                    $validator->errors()->add('campus_id', 'You can only create users for your assigned campus.');
                }
                
                // Security check 2: Cannot assign Super Admin role
                if ($this->role === 'Super Admin') {
                    $validator->errors()->add('role', 'You are not authorized to assign the Super Admin role.');
                }
            }
        });
    }
}
