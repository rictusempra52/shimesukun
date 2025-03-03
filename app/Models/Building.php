<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'address',
        'unit_count',
        'built_year',
    ];

    protected $casts = [
        'built_year' => 'integer',
        'unit_count' => 'integer',
    ];

    /**
     * このマンションを管理する会社を取得
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * このマンションの書類一覧を取得
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
