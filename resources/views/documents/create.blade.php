@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">書類アップロード</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- マンション選択 -->
                        <div class="mb-3">
                            <label for="building_id" class="form-label">マンション <span class="text-danger">*</span></label>
                            <select name="building_id" id="building_id" class="form-select @error('building_id') is-invalid @enderror" required>
                                <option value="">選択してください</option>
                                @foreach($buildings as $building)
                                    <option value="{{ $building->id }}" @selected(old('building_id') == $building->id)>
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
                                   value="{{ old('title') }}" required maxlength="255">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- ファイルアップロード -->
                        <div class="mb-4">
                            <label for="document" class="form-label">ファイル <span class="text-danger">*</span></label>
                            <input type="file" name="document" id="document" 
                                   class="form-control @error('document') is-invalid @enderror" required
                                   accept=".pdf,.jpg,.jpeg,.png">
                            <div class="form-text">
                                PDF、JPG、PNG形式のファイル（最大10MB）
                            </div>
                            @error('document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- ボタン -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary">
                                キャンセル
                            </a>
                            <button type="submit" class="btn btn-primary">
                                アップロード
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
