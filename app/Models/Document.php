<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'building_id',
        'user_id',
        'title',
        'file_path',
        'ocr_text',
    ];

    /**
     * この書類が属するマンションを取得
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * この書類をアップロードしたユーザーを取得
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 書類の検索機能
     */
    public function scopeSearch($query, $searchText)
    {
        return $query->where(function($q) use ($searchText) {
            $q->where('title', 'like', "%{$searchText}%")
              ->orWhere('ocr_text', 'like', "%{$searchText}%");
        });
    }
}
