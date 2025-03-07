@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg">
        <!-- ヘッダー -->
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium leading-6 text-gray-900">書類一覧</h3>
                <a href="{{ route('documents.create') }}"
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    新規アップロード
                </a>
            </div>
        </div>

        <div class="px-4 py-5 sm:p-6">
            <!-- 検索フォーム -->
            <form action="{{ route('documents.index') }}" method="GET" class="mb-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <select name="building_id"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">マンションを選択</option>
                            @foreach($buildings as $building)
                                <option value="{{ $building->id }}" @selected(request('building_id') == $building->id)>
                                    {{ $building->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <div class="flex rounded-md shadow-sm">
                            <input type="text" name="search" 
                                   class="focus:ring-indigo-500 focus:border-indigo-500 flex-grow block w-full min-w-0 rounded-none rounded-l-md sm:text-sm border-gray-300"
                                   placeholder="検索キーワード" 
                                   value="{{ request('search') }}">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-r-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                検索
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- 書類一覧テーブル -->
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">タイトル</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">マンション</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">アップロード日時</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">アップロードユーザー</th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">操作</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($documents as $document)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('documents.show', $document) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    {{ $document->title }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $document->building->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $document->created_at->format('Y/m/d H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $document->user->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-2">
                                                    <a href="{{ route('documents.edit', $document) }}"
                                                       class="text-indigo-600 hover:text-indigo-900">
                                                        編集
                                                    </a>
                                                    <form action="{{ route('documents.destroy', $document) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                onclick="return confirm('本当に削除しますか？')"
                                                                class="text-red-600 hover:text-red-900">
                                                            削除
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                書類が見つかりません。
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ページネーション -->
            <div class="mt-4">
                {{ $documents->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
