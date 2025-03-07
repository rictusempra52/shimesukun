@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg">
            <!-- ヘッダー -->
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">書類詳細</h3>
                    <div class="flex space-x-3">
                        <a href="{{ route('documents.edit', $document) }}"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            編集
                        </a>
                        <form action="{{ route('documents.destroy', $document) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('本当に削除しますか？')"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                削除
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="px-4 py-5 sm:p-6">
                <!-- 文書情報 -->
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">タイトル</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $document->title }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">マンション</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $document->building->name }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">アップロード日時</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $document->created_at->format('Y/m/d H:i') }}</dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">アップロードユーザー</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $document->user->name }}</dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">ファイル</dt>
                        <dd class="mt-1">
                            <div class="flex items-center">
                                <a href="{{ Storage::url($document->file_path) }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    target="_blank">
                                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    ダウンロード
                                </a>
                            </div>
                        </dd>
                    </div>

                    @if ($document->ocr_text)
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 mb-2">抽出テキスト</dt>
                            <dd class="mt-1">
                                <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-900 font-mono whitespace-pre-wrap">
                                    {{ $document->ocr_text }}
                                </div>
                            </dd>
                        </div>
                    @endif
                </dl>

                <!-- PDFプレビュー（PDFファイルの場合） -->
                @if (Str::endsWith($document->file_path, '.pdf'))
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">プレビュー</h4>
                        <div class="aspect-w-16 aspect-h-9">
                            <iframe src="{{ Storage::url($document->file_path) }}"
                                class="w-full h-[600px] rounded-lg border border-gray-200" frameborder="0"></iframe>
                        </div>
                    </div>
                @endif

                <!-- 画像プレビュー（画像ファイルの場合） -->
                @if (Str::endsWith($document->file_path, ['.jpg', '.jpeg', '.png']))
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">プレビュー</h4>
                        <img src="{{ Storage::url($document->file_path) }}" alt="{{ $document->title }}"
                            class="max-w-full h-auto rounded-lg border border-gray-200">
                    </div>
                @endif

                <!-- フッター -->
                <div class="mt-6">
                    <a href="{{ route('documents.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        一覧に戻る
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
