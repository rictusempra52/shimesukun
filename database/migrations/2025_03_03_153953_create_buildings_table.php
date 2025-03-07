<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * buildingsテーブルの作成
     * 
     * このマイグレーションでは建物情報を管理するためのテーブルを作成します。
     * companiesテーブルと紐付けられ、1つの会社が複数の建物を所有する関係を表現します。
     * 
     * 以下のカラムが含まれます：
     * - id: 主キー
     * - company_id: 所有会社のID（外部キー、会社が削除された場合は建物も削除）
     * - name: 建物名
     * - address: 建物の所在地
     * - unit_count: 区画数（建物内の部屋や区画の総数）
     * - built_year: 建築年
     * - timestamps: 作成日時と更新日時
     * - softDeletes: 論理削除用のタイムスタンプ
     */
    public function up(): void
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('address');
            $table->integer('unit_count');
            $table->year('built_year');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * マイグレーションの巻き戻し
     * 
     * buildingsテーブルを完全に削除します。
     * 関連する外部キー制約も自動的に削除されます。
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
