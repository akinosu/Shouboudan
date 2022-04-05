<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'name' => 'exists:users,name',
            'gender' => 'required|regex:/^[0-2]$/',
            'age' => 'required|integer',
            'subject' => 'required|max:80',
            'message' => 'required|max:350',
            'city_id' => 'required|exists:cities,id',
            'immigrant' => 'required|regex:/^[0-1]$/',
            'imgpath' => 'image',
        ];
    }

    public function messages()
    {
        return [
            'name.exists' => '名前の入力形式が不正です',
            'gender.required' => '性別を選択してください',
            'gender.regex' => '性別の入力形式が不正です',
            'subject.required' => '件名を入力してください',
            'subject.max' => '件名は80文字以内で入力してください',
            'message.required' => 'メッセージを入力してください',
            'message.max' => 'メッセージは350文字以内で入力してください',
            'city_id.required' => '市区町村を選択してください',
            'city_id.exists' => '市区町村の入力形式が不正です',
            'immigrant.required' => '市区町村との関係を選択してください',
            'immigrant.regex' => '市区町村との関係の入力形式が不正です',
            'imgpath.image' => '画像は画像形式で添付してください',
        ];
    }
}
