<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * documentsテーブルの作成
     * 
     * このマイグレーションでは文書管理のためのテーブルを作成します。
     * buildingsテーブルとusersテーブルに紐付けられ、以下の関係を表現します：
     * - 1つの建物に対して複数の文書が紐付く
     * - 各文書は1人のユーザーによって登録される
     * 
     * 以下のカラムが含まれます：
     * - id: 主キー
     * - building_id: 紐付く建物のID（外部キー、建物が削除された場合は文書も削除）
     * - user_id: 文書を登録したユーザーのID（外部キー、ユーザーが削除された場合は文書も削除）
     * - title: 文書のタイトル
     * - file_path: 保存されたファイルへのパス
     * - ocr_text: OCRで抽出されたテキストデータ（任意）
     * - timestamps: 作成日時と更新日時
     * - softDeletes: 論理削除用のタイムスタンプ
     * 
     * このテーブルはOCR機能を備えており、アップロードされた文書から
     * テキストを抽出して検索可能な形式で保存することができます。
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('file_path');
            $table->text('ocr_text')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * マイグレーションの巻き戻し
     * 
     * documentsテーブルを完全に削除します。
     * 注意：これは実際のファイルシステム上のドキュメントファイルは削除しません。
     * ファイルの削除は別途クリーンアップ処理で行う必要があります。
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
