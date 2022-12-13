<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'max:255'],
            'last_name' => ['nullable', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user), 'max:255'],
            'username' => ['required', Rule::unique('users', 'username')->ignore($this->user)], 'max:255',
            'new_password' => ['nullable', 'min:8', 'max:255'],
            'password_confirmation' => ['nullable', 'min:8', 'max:255'],
            'address' => ['required', 'max:255'],
            'phone_number' => ['required', 'max:255'],
            'avatar' => ['image', 'mimes:png,jpg,jpeg', 'max:2048']
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Nama depan harus diisi',
            'email.required' => 'Email harus diisi',
            'email.eamil' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah terdaftar',
            'new_password.min' => 'Password minimal 8 karakter',
            'password_confirmation.min' => 'Password minimal 8 karakter',
            'alamat.required' => 'Alamat harus diisi',
            'phone_number.required' => 'Nomor telepon depan harus diisi',
            'avatar.image' => 'Foto profil harus berformat gambar dengan ekstensi .png atau .jpg',
            'avatr.max' => "Ukuran maksimal foto profil adalah 2048KB atau 2MB"
        ];
    }
}
