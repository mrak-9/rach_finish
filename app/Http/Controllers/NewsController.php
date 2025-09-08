<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('news.index', compact('news'));
    }

    public function show(News $news)
    {
        // Проверяем, что новость опубликована
        if (!$news->is_published) {
            abort(404);
        }

        return view('news.show', compact('news'));
    }

    /**
     * API: Получить список новостей
     */
    public function apiIndex(Request $request)
    {
        $perPage = min($request->get('per_page', 10), 50); // Максимум 50 записей за раз
        
        $news = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'data' => $news->items(),
            'current_page' => $news->currentPage(),
            'per_page' => $news->perPage(),
            'total' => $news->total(),
            'last_page' => $news->lastPage(),
            'has_more_pages' => $news->hasMorePages(),
        ]);
    }

    /**
     * API: Получить конкретную новость
     */
    public function apiShow(News $news)
    {
        // Проверяем, что новость опубликована
        if (!$news->is_published) {
            return response()->json(['error' => 'Новость не найдена'], 404);
        }

        return response()->json(['data' => $news]);
    }
}
