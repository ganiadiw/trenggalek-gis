<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user()->id), 'max:255'],
            'username' => ['required', Rule::unique('users', 'username')->ignore($this->user()->id), 'max:255'],
            'password' => ['nullable', 'min:8', 'max:255', 'confirmed'],
            'password_confirmation' => [],
            'address' => ['required', 'max:255'],
            'phone_number' => ['required', 'max:255'],
            'avatar' => ['image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama',
            'email' => 'Surel',
            'username' => 'Nama Pengguna',
            'password' => 'Kata Sandi',
            'address' => 'Alamat',
            'phone_number' => 'Nomor Handphone',
        ];
    }
}
