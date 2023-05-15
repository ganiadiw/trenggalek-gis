<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email', 'max:255'],
            'username' => ['required', 'unique:users,username', 'max:255'],
            'password' => ['required', 'min:8', 'max:255'],
            'address' => ['required', 'max:255'],
            'phone_number' => ['required', 'max:255'],
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
