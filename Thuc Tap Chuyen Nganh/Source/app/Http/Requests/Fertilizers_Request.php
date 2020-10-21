<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Fertilizers_Request extends FormRequest
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
            'name' => 'required|unique:fertilizers,name',
            'mass' => 'required:fertilizers,mass'
            // tên trường =>'ko để trống|ko trùng: tên bảng, tên thuộc tính'
            
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please Enter Fertilizers name!',
            'name.unique' => 'This Fertilizers name is Exist!',
            'mass.required' => 'Please Enter Fertilizers density!',
            
    }
}
