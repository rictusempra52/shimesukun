<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * companiesテーブルの作成
     * 
     * このマイグレーションでは会社情報を管理するための基本テーブルを作成します。
     * 以下のカラムが含まれます：
     * - id: 主キー
     * - name: 会社名
     * - address: 会社の所在地
     * - timestamps: 作成日時と更新日時
     * - softDeletes: 論理削除用のタイムスタンプ
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // テーブルが存在する場合、完全に削除します
        Schema::dropIfExists('companies');
    }
};
