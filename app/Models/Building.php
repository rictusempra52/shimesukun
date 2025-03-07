<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 建物モデル
 * 
 * このモデルは建物の基本情報を管理し、以下の関係を持ちます：
 * - 会社モデルとの多対1の関係（1つの会社が複数の建物を所有）
 * - 文書モデルとの1対多の関係（1つの建物に複数の文書が紐付く）
 * 
 * 使用しているトレイト：
 * - HasFactory: モデルファクトリーを使用可能にする（テスト用データ生成に使用）
 * - SoftDeletes: 論理削除を有効にする（レコードを完全に削除せず、deleted_atフラグで管理）
 * 
 * @property int $id ID
 * @property int $company_id 所有会社ID
 * @property string $name 建物名
 * @property string $address 所在地
 * @property int $unit_count 区画数
 * @property int $built_year 建築年
 * @property \Carbon\Carbon $created_at 作成日時
 * @property \Carbon\Carbon $updated_at 更新日時
 * @property \Carbon\Carbon|null $deleted_at 削除日時
 * @property-read \App\Models\Company $company 所有会社
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\Document> $documents 関連文書
 */
class Building extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * 一括割り当て可能な属性
     * 
     * これらのフィールドはマスアサインメント（create()やupdate()メソッド）で
     * 値を設定することができます。
     * 
     * @var array<string>
     */
    protected $fillable = [
        'company_id',
        'name',
        'address',
        'unit_count',
        'built_year',
    ];

    /**
     * 属性の型変換定義
     * 
     * データベースから取得した値を自動的に指定した型に変換します：
     * - built_year: 文字列から整数への変換
     * - unit_count: 文字列から整数への変換
     * 
     * @var array<string, string>
     */
    protected $casts = [
        'built_year' => 'integer',
        'unit_count' => 'integer',
    ];

    /**
     * この建物を所有する会社を取得
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * この建物に関連する文書一覧を取得
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
