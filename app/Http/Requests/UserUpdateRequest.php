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
        // dd($this->route('users.show', ['user' => $this->username]));
        return [
            'first_name' => ['required'],
            'last_name' => ['nullable'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->username)],
            'username' => ['required', Rule::unique('users', 'username')->ignore($this->id)],
            'new_password' => ['nullable', 'min:8'],
            'password_confirmation' => ['nullable', 'min:8'],
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
            'new_password.min' => 'Password minimal 8 karakter',
            'password_confirmation.min' => 'Password minimal 8 karakter',
            'alamat.required' => 'Alamat harus diisi',
            'phone_number.required' => 'Nomor telepon depan harus diisi',
        ];
    }
}
