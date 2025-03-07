<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Models\Building;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * 文書管理コントローラ
 * 
 * 建物に関連する文書の管理機能（CRUD操作）を提供します。
 * 主な機能：
 * - 文書一覧の表示（検索・フィルタリング機能付き）
 * - 新規文書のアップロード（OCRテキスト抽出機能付き）
 * - 文書詳細の表示
 * - 文書情報の編集
 * - 文書の削除（ファイルシステムからの物理削除含む）
 * 
 * 使用しているトレイト：
 * - AuthorizesRequests: 認可機能を提供
 * - ValidatesRequests: バリデーション機能を提供
 */
class DocumentController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * 文書一覧を表示
     * 
     * 以下の機能を提供：
     * - 文書の一覧表示（ページネーション付き、1ページ20件）
     * - タイトル・OCRテキストによる検索
     * - 建物によるフィルタリング
     * - 関連する建物とユーザー情報の取得（Eager Loading）
     * 
     * @param Request $request リクエスト情報
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Document::with(['building', 'user']);
        $buildings = Building::all();

        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->has('building_id')) {
            $query->where('building_id', $request->building_id);
        }

        $documents = $query->latest()->paginate(20);

        return view('documents.index', compact('documents', 'buildings'));
    }

    /**
     * 文書アップロードフォームを表示
     * 
     * 新規文書のアップロードフォームを表示します。
     * 文書を関連付ける建物の選択肢も提供します。
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $buildings = Building::all();
        return view('documents.create', compact('buildings'));
    }

    /**
     * 新規文書をアップロード
     * 
     * 以下の処理を実行：
     * 1. アップロードされたファイルを保存
     * 2. PDFファイルの場合、OCRでテキストを抽出
     * 3. データベースに文書情報を登録
     * 
     * @param StoreDocumentRequest $request バリデーション済みのリクエスト
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDocumentRequest $request)
    {
        $file = $request->file('document');
        $path = $file->store('documents', 'public');

        // PDFからテキストを抽出
        $ocr_text = null;
        if ($file->getClientOriginalExtension() === 'pdf') {
            $ocr = new TesseractOCR($file->getRealPath());
            $ocr_text = $ocr->run();
        }

        $document = Document::create([
            'building_id' => $request->building_id,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'file_path' => $path,
            'ocr_text' => $ocr_text,
        ]);

        return redirect()
            ->route('documents.show', $document)
            ->with('success', '書類がアップロードされました。');
    }

    /**
     * 文書の詳細を表示
     * 
     * 指定された文書の詳細情報を表示します。
     * 暗黙的なモデルバインディングを使用してドキュメントを取得します。
     * 
     * @param Document $document 表示対象の文書
     * @return \Illuminate\View\View
     */
    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    /**
     * 文書の編集フォームを表示
     * 
     * 指定された文書の編集フォームを表示します。
     * 文書を関連付ける建物の選択肢も提供します。
     * 
     * @param Document $document 編集対象の文書
     * @return \Illuminate\View\View
     */
    public function edit(Document $document)
    {
        $buildings = Building::all();
        return view('documents.edit', compact('document', 'buildings'));
    }

    /**
     * 文書情報を更新
     * 
     * タイトルと関連建物の情報を更新します。
     * ファイル自体の更新は現在サポートしていません。
     * 
     * @param Request $request 更新リクエスト
     * @param Document $document 更新対象の文書
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'building_id' => 'required|exists:buildings,id',
        ]);

        $document->update($validated);

        return redirect()
            ->route('documents.show', $document)
            ->with('success', '書類が更新されました。');
    }

    /**
     * 文書を削除
     * 
     * 以下の処理を実行：
     * 1. ストレージから物理ファイルを削除
     * 2. データベースから文書レコードを削除（ソフトデリート）
     * 
     * @param Document $document 削除対象の文書
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Document $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return redirect()
            ->route('documents.index')
            ->with('success', '書類が削除されました。');
    }
}
