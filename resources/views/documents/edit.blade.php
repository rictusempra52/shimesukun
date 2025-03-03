@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">書類編集</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('documents.update', $document) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- マンション選択 -->
                        <div class="mb-3">
                            <label for="building_id" class="form-label">マンション <span class="text-danger">*</span></label>
                            <select name="building_id" id="building_id" class="form-select @error('building_id') is-invalid @enderror" required>
                                <option value="">選択してください</option>
                                @foreach($buildings as $building)
                                    <option value="{{ $building->id }}" @selected(old('building_id', $document->building_id) == $building->id)>
                                        {{ $building->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('building_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- タイトル -->
                        <div class="mb-3">
                            <label for="title" class="form-label">タイトル <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $document->title) }}" required maxlength="255">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 現在のファイル -->
                        <div class="mb-4">
                            <label class="form-label">現在のファイル</label>
                            <div>
                                <a href="{{ Storage::url($document->file_path) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="bi bi-download"></i> ダウンロード
                                </a>
                            </div>
                            <div class="form-text">
                                ※ファイルの変更は新規アップロードが必要です
                            </div>
                        </div>

                        <!-- ボタン -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('documents.show', $document) }}" class="btn btn-outline-secondary">
                                キャンセル
                            </a>
                            <button type="submit" class="btn btn-primary">
                                更新
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card-header {
    background-color: #f8f9fa;
}
</style>
@endpush
