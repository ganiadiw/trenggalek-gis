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

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi',
            'name.max' => 'Maksimal 255 karakter',
            'email.required' => 'Email harus diisi',
            'email.eamil' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'email.max' => 'Maksimal 255 karakter',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah terdaftar',
            'username.max' => 'Maksimal 255 karakter',
            'password.min' => 'Password minimal 8 karakter',
            'password.max' => 'Maksimal 255 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'address.required' => 'Alamat harus diisi',
            'address.max' => 'Maksimal 255 karakter',
            'phone_number.required' => 'Nomor telepon harus diisi',
            'avatar.image' => 'Foto profil harus berformat gambar dengan ekstensi .png atau .jpg',
            'avatar.max' => 'Ukuran maksimal foto profil adalah 2048KB atau 2MB',
        ];
    }
}
