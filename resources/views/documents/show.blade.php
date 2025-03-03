@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">書類詳細</h5>
                    <div>
                        <a href="{{ route('documents.edit', $document) }}" class="btn btn-outline-primary">編集</a>
                        <form action="{{ route('documents.destroy', $document) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('本当に削除しますか？')">
                                削除
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th class="bg-light" style="width: 150px;">タイトル</th>
                            <td>{{ $document->title }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">マンション</th>
                            <td>{{ $document->building->name }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">アップロード日時</th>
                            <td>{{ $document->created_at->format('Y/m/d H:i') }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">アップロードユーザー</th>
                            <td>{{ $document->user->name }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">ファイル</th>
                            <td>
                                <a href="{{ Storage::url($document->file_path) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="bi bi-download"></i> ダウンロード
                                </a>
                            </td>
                        </tr>
                        @if($document->ocr_text)
                            <tr>
                                <th class="bg-light">抽出テキスト</th>
                                <td>
                                    <div class="border rounded p-3 bg-light">
                                        {!! nl2br(e($document->ocr_text)) !!}
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </table>

                    <div class="mt-4">
                        <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary">
                            一覧に戻る
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
