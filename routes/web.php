<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Webルート定義
|--------------------------------------------------------------------------
|
| このファイルではアプリケーションのWebルートを定義します。
| 全てのルートは"web"ミドルウェアグループに属し、
| セッション状態やCSRF保護などの機能が自動的に適用されます。
|
*/

/**
 * トップページ
 * 
 * アプリケーションのウェルカムページを表示します。
 * ユーザーは未ログインでもアクセス可能です。
 */
Route::get('/', function () {
    return view('welcome');
});

/**
 * 認証関連のルート
 * 
 * 以下の認証関連ルートが自動的に生成されます：
 * - ログインフォーム表示 (GET /login)
 * - ログイン処理 (POST /login)
 * - ログアウト処理 (POST /logout)
 * - パスワードリセット関連
 * - ユーザー登録関連
 */
Auth::routes();

/**
 * 認証済みユーザー専用ルート
 * 
 * このグループ内のルートにアクセスするには、
 * ユーザーがログインしている必要があります。
 * ログインしていない場合は自動的にログインページにリダイレクトされます。
 */
Route::middleware(['auth'])->group(function () {
    /**
     * ダッシュボード
     * 
     * ログイン後のホーム画面を表示します。
     * 建物や文書の概要情報が表示されます。
     */
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    /**
     * 文書管理機能
     * 
     * RESTfulなリソースルートを自動生成します：
     * - 一覧表示 (GET /documents)
     * - 詳細表示 (GET /documents/{document})
     * - 作成フォーム (GET /documents/create)
     * - 新規作成処理 (POST /documents)
     * - 編集フォーム (GET /documents/{document}/edit)
     * - 更新処理 (PUT/PATCH /documents/{document})
     * - 削除処理 (DELETE /documents/{document})
     * 
     * 各ルートはDocumentControllerの対応するメソッドにマッピングされます。
     */
    Route::resource('documents', DocumentController::class);
});
