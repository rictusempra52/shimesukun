<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 会社モデル
 * 
 * このモデルは会社の基本情報を管理し、建物との1対多の関係を持ちます。
 * 
 * 使用しているトレイト：
 * - HasFactory: モデルファクトリーを使用可能にする（テスト用データ生成に使用）
 * - SoftDeletes: 論理削除を有効にする（レコードを完全に削除せず、deleted_atフラグで管理）
 * 
 * @property int $id ID
 * @property string $name 会社名
 * @property string $address 所在地
 * @property \Carbon\Carbon $created_at 作成日時
 * @property \Carbon\Carbon $updated_at 更新日時
 * @property \Carbon\Carbon|null $deleted_at 削除日時
 */
class Company extends Model
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
        'name',
        'address',
    ];

    /**
     * この会社が所有する建物の一覧を取得
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function buildings()
    {
        return $this->hasMany(Building::class);
    }
}
