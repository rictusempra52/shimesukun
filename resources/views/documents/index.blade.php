@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">書類一覧</h5>
                    <a href="{{ route('documents.create') }}" class="btn btn-primary">新規アップロード</a>
                </div>

                <div class="card-body">
                    <!-- 検索フォーム -->
                    <form action="{{ route('documents.index') }}" method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <select name="building_id" class="form-select">
                                    <option value="">マンションを選択</option>
                                    @foreach($buildings as $building)
                                        <option value="{{ $building->id }}" @selected(request('building_id') == $building->id)>
                                            {{ $building->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="検索キーワード" value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-outline-secondary">検索</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- 書類一覧テーブル -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>タイトル</th>
                                    <th>マンション</th>
                                    <th>アップロード日時</th>
                                    <th>アップロードユーザー</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $document)
                                    <tr>
                                        <td>
                                            <a href="{{ route('documents.show', $document) }}">
                                                {{ $document->title }}
                                            </a>
                                        </td>
                                        <td>{{ $document->building->name }}</td>
                                        <td>{{ $document->created_at->format('Y/m/d H:i') }}</td>
                                        <td>{{ $document->user->name }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('documents.edit', $document) }}" class="btn btn-sm btn-outline-primary">
                                                    編集
                                                </a>
                                                <form action="{{ route('documents.destroy', $document) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('本当に削除しますか？')">
                                                        削除
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">書類が見つかりません。</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- ページネーション -->
                    <div class="d-flex justify-content-center">
                        {{ $documents->links() }}
                    </div>
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
.table th {
    background-color: #f8f9fa;
}
</style>
@endpush
