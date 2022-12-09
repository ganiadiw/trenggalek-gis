<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'first_name' => ['required'],
            'last_name' => ['nullable'],
            'email' => ['required', 'email', 'unique:users,email'],
            'username' => ['required', 'unique:users,username'],
            'password' => ['required', 'min:8'],
            'address' => ['required'],
            'phone_number' => ['required'],
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
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'alamat.required' => 'Alamat harus diisi',
            'phone_number.required' => 'Nomor telepon depan harus diisi',
        ];
    }
}
