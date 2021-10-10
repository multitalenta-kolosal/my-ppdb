<?php

namespace Modules\Referal\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class RefereesRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required|max:191',
            'email'             => 'email|unique:referees', 
            'phone'             => 'numeric|unique:referees',
        ];
    }

    public function messages()
    {
        return [
                'email' => [
                'required' => 'Alamat Email Dibutuhkan!',
                'max' => 'Alamat Email Terlalu panjang!',
                'unique' => 'Alamat Email sudah terdaftar'
            ],
            'phone' => [
                'required' => 'Nomor HP Dibutuhkan!',
                'max' => 'Nomor HP Terlalu panjang!',
                'unique' => 'Nomor HP sudah terdaftar'
            ],
        ];
    }
}