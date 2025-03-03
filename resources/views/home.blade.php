@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- 統計カード -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">マンション数</h5>
                            <p class="display-4">{{ $buildingCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">登録書類数</h5>
                            <p class="display-4">{{ $documentCount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 最近のアップロード -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">最近のアップロード</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>タイトル</th>
                                    <th>マンション</th>
                                    <th>アップロード日時</th>
                                    <th>アップロードユーザー</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentDocuments as $document)
                                    <tr>
                                        <td>
                                            <a href="{{ route('documents.show', $document) }}">
                                                {{ $document->title }}
                                            </a>
                                        </td>
                                        <td>{{ $document->building->name }}</td>
                                        <td>{{ $document->created_at->format('Y/m/d H:i') }}</td>
                                        <td>{{ $document->user->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">書類が見つかりません。</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('documents.index') }}" class="btn btn-primary">
                            すべての書類を表示
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}
.table th {
    background-color: #f8f9fa;
}
</style>
@endpush
