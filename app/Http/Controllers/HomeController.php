<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class HomeController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    
    /**
     * ダッシュボードを表示
     */
    public function index()
    {
        $recentDocuments = Document::with(['building', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $buildingCount = Building::count();
        $documentCount = Document::count();

        return view('home', compact(
            'recentDocuments',
            'buildingCount',
            'documentCount'
        ));
    }
}
