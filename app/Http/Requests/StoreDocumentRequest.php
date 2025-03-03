<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // ログインユーザーのみアクセス可能（認証ミドルウェアで制御）
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'building_id' => ['required', 'exists:buildings,id'],
            'title' => ['required', 'string', 'max:255'],
            'document' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:10240', // 最大10MB
            ],
        ];
    }

    /**
     * バリデーションメッセージの日本語化
     */
    public function messages(): array
    {
        return [
            'building_id.required' => 'マンションを選択してください。',
            'building_id.exists' => '選択されたマンションは存在しません。',
            'title.required' => 'タイトルを入力してください。',
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'document.required' => 'ファイルを選択してください。',
            'document.file' => '有効なファイルを選択してください。',
            'document.mimes' => 'PDF、JPG、PNGファイルのみアップロード可能です。',
            'document.max' => 'ファイルサイズは10MB以内にしてください。',
        ];
    }
}
