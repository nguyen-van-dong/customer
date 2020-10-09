<?php

namespace Module\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
//            'firstname' => 'required',
//            'lastname' => 'required',
//            'email' => 'required',
//            'phone' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('customer::address.name'),
        ];
    }
}
