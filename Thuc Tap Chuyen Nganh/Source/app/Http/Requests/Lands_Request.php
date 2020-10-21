<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Lands_Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name' => 'required|unique:lands,name',
            'quanty_crops' => 'required:lands,quanty_crops',
            'square' => 'required:lands,square',
            // tên trường =>'ko để trống|ko trùng: tên bảng, tên thuộc tính'
            
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please Enter Lands name!',
            'name.unique' => 'This Lands name is Exist!',
            'quanty_crops.required' => 'Please Enter Lands quantity of crops!',
            'square.required' => 'Please Enter square of Lands!'
            
    }
}
