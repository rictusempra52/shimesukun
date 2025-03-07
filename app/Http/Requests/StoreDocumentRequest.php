<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 文書保存リクエストバリデーション
 * 
 * このフォームリクエストクラスは、文書のアップロード時に送信される
 * データのバリデーションルールとエラーメッセージを定義します。
 * 
 * 主な機能：
 * - 認証済みユーザーのみアクセスを許可
 * - 必須項目のチェック
 * - ファイルの種類とサイズの制限
 * - カスタマイズされた日本語のエラーメッセージ
 */
class StoreDocumentRequest extends FormRequest
{
    /**
     * リクエストの認証チェック
     * 
     * このメソッドでは、現在のユーザーがこのリクエストを実行する権限があるかどうかを判断します。
     * 認証は既にミドルウェアで処理されているため、常にtrueを返します。
     * 
     * @return bool 常にtrue（認証チェックはミドルウェアに委任）
     */
    public function authorize(): bool
    {
        return true; // ログインユーザーのみアクセス可能（認証ミドルウェアで制御）
    }

    /**
     * バリデーションルールの定義
     * 
     * 文書アップロード時に適用される各項目のバリデーションルールを定義します：
     * - building_id: 必須、buildingsテーブルに実在するID
     * - title: 必須、文字列、最大255文字
     * - document: 必須、ファイル、特定の拡張子のみ許可、サイズ制限あり
     * 
     * @return array バリデーションルールの配列
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
     * カスタマイズされたバリデーションメッセージ
     * 
     * バリデーションエラー発生時に表示される日本語のエラーメッセージを定義します。
     * ユーザーフレンドリーな表現を使用し、具体的な対応方法を示します。
     * 
     * 主なメッセージ：
     * - 必須項目が未入力の場合のメッセージ
     * - ファイル形式が不正な場合のメッセージ
     * - ファイルサイズ超過時のメッセージ
     * 
     * @return array エラーメッセージの配列
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
