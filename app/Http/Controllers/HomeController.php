<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * ホーム画面コントローラ
 * 
 * ダッシュボード画面を提供し、システム全体の概要を表示します。
 * 表示される情報：
 * - 最近アップロードされた文書（最新5件）
 * - 登録済み建物の総数
 * - アップロード済み文書の総数
 * 
 * 使用しているトレイト：
 * - AuthorizesRequests: 認可機能を提供
 * - ValidatesRequests: バリデーション機能を提供
 */
class HomeController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * ダッシュボード画面を表示
     * 
     * システムの現在の状態を示す統計情報と、
     * 最新の文書情報を取得して表示します。
     * 
     * 取得する情報：
     * - recentDocuments: 最新の文書5件（関連する建物とユーザー情報も含む）
     * - buildingCount: 登録されている建物の総数
     * - documentCount: アップロードされている文書の総数
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 最新の文書5件を取得（関連データも一緒にロード）
        $recentDocuments = Document::with(['building', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // 統計情報を取得
        $buildingCount = Building::count();
        $documentCount = Document::count();

        return view('home', compact(
            'recentDocuments',
            'buildingCount',
            'documentCount'
        ));
    }
}
