<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Crops_Request extends FormRequest
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
            'name' => 'required|unique:crops,name',
            'density' => 'required:crops,density'
            // tên trường =>'ko để trống|ko trùng: tên bảng, tên thuộc tính'
            
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please Enter Crops name!',
            'name.unique' => 'This Crops name is Exist!',
            'density.required' => 'Please Enter Crops density!',
            
    }
}
