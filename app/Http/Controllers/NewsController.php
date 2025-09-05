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
}
