<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class DailyReportRequest extends FormRequest
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
            'reporting_time' => 'required|date',
            'title' => 'required|string|max:255',
            'contents' => 'required|string',
            'user_id' => 'required'
        ];
    }

    public function messages()
    {
        //
        return [
            'required' => '入力必須の項目です',
            'max' =>'255文字以内で入力してください',
            'user_id.required' => '不正な操作です'
        ];
    }
}

