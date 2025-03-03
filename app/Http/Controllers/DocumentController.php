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

class DocumentController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * 書類一覧を表示
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
     * 書類アップロードフォームを表示
     */
    public function create()
    {
        $buildings = Building::all();
        return view('documents.create', compact('buildings'));
    }

    /**
     * 書類をアップロード
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
     * 書類の詳細を表示
     */
    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    /**
     * 書類の編集フォームを表示
     */
    public function edit(Document $document)
    {
        $buildings = Building::all();
        return view('documents.edit', compact('document', 'buildings'));
    }

    /**
     * 書類を更新
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
     * 書類を削除
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
