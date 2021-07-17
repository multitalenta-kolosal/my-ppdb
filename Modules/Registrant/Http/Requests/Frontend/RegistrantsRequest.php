<?php

namespace Modules\Registrant\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class RegistrantsRequest extends FormRequest
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
            'phone'             => 'required|numeric',
            'type'              => 'required',
            'unit_id'           => 'required',
        ];
    }
}
