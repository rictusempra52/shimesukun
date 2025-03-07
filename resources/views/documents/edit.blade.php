@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="pb-5 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">書類編集</h3>
            </div>

            <form action="{{ route('documents.update', $document) }}" method="POST" class="mt-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- マンション選択 -->
                <div>
                    <label for="building_id" class="block text-sm font-medium text-gray-700">
                        マンション <span class="text-red-500">*</span>
                    </label>
                    <select name="building_id" id="building_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                   @error('building_id') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                            required>
                        <option value="">選択してください</option>
                        @foreach($buildings as $building)
                            <option value="{{ $building->id }}" @selected(old('building_id', $document->building_id) == $building->id)>
                                {{ $building->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('building_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- タイトル -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">
                        タイトル <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                  @error('title') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                           value="{{ old('title', $document->title) }}" required maxlength="255">
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 現在のファイル -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">現在のファイル</label>
                    <div class="mt-2">
                        <a href="{{ Storage::url($document->file_path) }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                           target="_blank">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            ダウンロード
                        </a>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        ※ファイルの変更は新規アップロードが必要です
                    </p>
                </div>

                <!-- ボタン -->
                <div class="flex justify-end gap-4 pt-4">
                    <a href="{{ route('documents.show', $document) }}"
                       class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        キャンセル
                    </a>
                    <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        更新
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
