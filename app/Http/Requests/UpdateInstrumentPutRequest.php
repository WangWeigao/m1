<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateInstrumentPutRequest extends Request
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
            'name' => 'required|unique:instruments|min:1|max:255',
        ];
    }

    /**
     * 自定义显示信息
     * @return [type] [description]
     */
    public function messages()
    {
        return [
            'name.required' => '乐器名称不能为空',
            'name.unique'  => '乐器已经存在',
            'name.min'  => '乐器名称长度至少为1个字符',
            'name.max'  => '乐器名称长度至少为255个字符',
        ];
    }
}
