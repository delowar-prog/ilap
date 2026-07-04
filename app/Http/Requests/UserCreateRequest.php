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
     * ১. অথরাইজেশন চেক (যার 'create user' পারমিশন আছে সে কি রিকোয়েস্ট করতে পারছে?)
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('User Add');
    }

    /**
     * ২. ভ্যালিডেশন রুলস
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
     * ৩. কাস্টম এরর মেসেজ (ঐচ্ছিক কিন্তু ভালো প্র্যাকটিস)
     */
    public function messages(): array
    {
        return [
            'role.exists'       => 'নির্বাচিত রোলটি সঠিক নয় বা সিস্টেমে নেই।',
            'campus_id.exists'  => 'নির্বাচিত ব্রাঞ্চটি সঠিক নয় বা সিস্টেমে নেই।',
            'password.confirmed'=> 'পাসওয়ার্ড এবং কনফার্ম পাসওয়ার্ড মিলছে না।',
            'photo.image'       => 'শুধুমাত্র ইমেজ ফাইল (jpg, png) আপলোড করুন।',
        ];
    }

    /**
     * ৪. মাল্টি-ব্রাঞ্চ ও রোল সিকিউরিটি চেক (সবচেয়ে গুরুত্বপূর্ণ)
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $currentUser = auth()->user();
            
            // সিকিউরিটি ১: সুপার এডমিন ছাড়া অন্যরা শুধু নিজের ব্রাঞ্চের ইউজার তৈরি করতে পারবে
            if (!$currentUser->hasRole('Super Admin')) {
                if ($this->campus_id != $currentUser->campus_id) {
                    $validator->errors()->add('campus_id', 'আপনি শুধুমাত্র নিজের ব্রাঞ্চের জন্য ইউজার তৈরি করতে পারবেন।');
                }
                
                // সিকিউরিটি ২: ব্রাঞ্চ এডমিন/স্টাফ কখনোই সুপার এডমিন রোল অ্যাসাইন করতে পারবে না
                if ($this->role === 'Super Admin') {
                    $validator->errors()->add('role', 'আপনি সুপার এডমিন রোল অ্যাসাইন করার অনুমতি পান না।');
                }
            }
        });
    }
}
