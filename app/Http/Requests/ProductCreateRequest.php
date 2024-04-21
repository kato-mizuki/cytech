<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'comment' => 'string|max:255',
            'image_path' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'company_id' => 'required|exists:companies,id'
        ];
    }

    public function messages() {
        return [
            'name.required' => '商品名は必ず入力してください。',
            'price.required' => '価格は必ず入力してください。',
            'price.numeric' => '価格は数字で入力してください。',
            'price.min' => '価格は0以上で入力してください。',
            'stock.required' => '在庫数は必ず入力してください',
            'stock.numeric' => '在庫数は数字で入力してください。',
            'stock.min' => '在庫数は0以上で入力してください。',
            'company_id.required' => '企業名は必ず選択してください。',
            'company_id.exists' => '選択した企業が存在しません。',
            //'image_path.file' => 'ファイルをアップロードしてください。',
            //'image_path.image' => '画像を選択してください。',
            'image_path.mimes' => '画像ファイルはjpeg,png,jpg形式のみ対応しています。',
            'image_path.max' => 'ファイルサイズは2MB以内にしてください。'
        ];
    }
}