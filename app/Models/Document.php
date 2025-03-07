<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 文書モデル
 * 
 * このモデルは建物に関連する文書情報を管理し、以下の関係を持ちます：
 * - 建物モデルとの多対1の関係（1つの建物に複数の文書が紐付く）
 * - ユーザーモデルとの多対1の関係（1人のユーザーが複数の文書をアップロード可能）
 * 
 * 特徴：
 * - OCRによるテキスト抽出機能を備えており、文書内容の全文検索が可能
 * - タイトルとOCRテキストの両方を対象とした検索機能を提供
 * 
 * 使用しているトレイト：
 * - HasFactory: モデルファクトリーを使用可能にする（テスト用データ生成に使用）
 * - SoftDeletes: 論理削除を有効にする（レコードを完全に削除せず、deleted_atフラグで管理）
 * 
 * @property int $id ID
 * @property int $building_id 建物ID
 * @property int $user_id アップロードユーザーID
 * @property string $title 文書タイトル
 * @property string $file_path ファイルパス
 * @property string|null $ocr_text OCR抽出テキスト
 * @property \Carbon\Carbon $created_at 作成日時
 * @property \Carbon\Carbon $updated_at 更新日時
 * @property \Carbon\Carbon|null $deleted_at 削除日時
 * @property-read \App\Models\Building $building 関連建物
 * @property-read \App\Models\User $user アップロードユーザー
 */
class Document extends Model
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
        'building_id',
        'user_id',
        'title',
        'file_path',
        'ocr_text',
    ];

    /**
     * この文書が属する建物を取得
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * この文書をアップロードしたユーザーを取得
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 文書の検索機能
     * 
     * タイトルまたはOCRテキスト内に指定された検索文字列が
     * 含まれる文書を検索します。検索は部分一致で行われます。
     * 
     * 使用例：
     * Document::search('検索文字列')->get();
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $searchText 検索文字列
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $searchText)
    {
        return $query->where(function($q) use ($searchText) {
            $q->where('title', 'like', "%{$searchText}%")
              ->orWhere('ocr_text', 'like', "%{$searchText}%");
        });
    }
}
