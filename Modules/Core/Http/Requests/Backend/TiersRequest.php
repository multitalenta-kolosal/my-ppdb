<?php

namespace Modules\Core\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class TiersRequest extends FormRequest
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
            'tier_name'              => 'required|max:191',
            'unit_id'           => 'required',
            'contact_number'    => 'nullable|numeric',
            'contact_email'     => 'nullable|email',
            'tier_requirements'      => 'nullable|max:255',
        ];
    }
}
