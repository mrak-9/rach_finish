<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Conference;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestNews = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        $upcomingConferences = Conference::where('registration_start_date', '<=', now())
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->limit(3)
            ->get();

        return view('home', compact('latestNews', 'upcomingConferences'));
    }
}
