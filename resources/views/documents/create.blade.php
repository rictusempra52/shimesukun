@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="pb-5 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">書類アップロード</h3>
                </div>

                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data"
                    class="mt-6 space-y-6">
                    @csrf

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
                            @foreach ($buildings as $building)
                                <option value="{{ $building->id }}" @selected(old('building_id') == $building->id)>
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
                            value="{{ old('title') }}" required maxlength="255">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ファイルアップロード -->
                    <div>
                        <label for="document" class="block text-sm font-medium text-gray-700">
                            ファイル <span class="text-red-500">*</span>
                        </label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="document"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>ファイルを選択</span>
                                        <input id="document" name="document" type="file" accept=".pdf,.jpg,.jpeg,.png"
                                            class="sr-only" required>
                                    </label>
                                    <p class="pl-1">またはドラッグ&ドロップ</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF、JPG、PNG形式（最大10MB）</p>
                            </div>
                        </div>
                        @error('document')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <!-- プレビュー表示エリア -->
                        <div id="preview" class="mt-4 hidden">
                            <p class="text-sm text-gray-500">選択されたファイル:</p>
                            <p id="fileName" class="text-sm font-medium text-gray-900"></p>
                        </div>
                    </div>

                    <!-- ボタン -->
                    <div class="flex justify-end gap-4 pt-4">
                        <a href="{{ route('documents.index') }}"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            キャンセル
                        </a>
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            アップロード
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('document').addEventListener('change', function(e) {
                const preview = document.getElementById('preview');
                const fileName = document.getElementById('fileName');

                if (e.target.files.length > 0) {
                    preview.classList.remove('hidden');
                    fileName.textContent = e.target.files[0].name;
                } else {
                    preview.classList.add('hidden');
                    fileName.textContent = '';
                }
            });
        </script>
    @endpush
@endsection
