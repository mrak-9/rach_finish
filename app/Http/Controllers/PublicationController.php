<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PublicationController extends Controller
{
    public function index()
    {
        $publications = Publication::orderBy('published_at', 'desc')
            ->paginate(10);

        return view('publications.index', compact('publications'));
    }

    public function show(Publication $publication)
    {
        return view('publications.show', compact('publication'));
    }

    public function download(Publication $publication, $file)
    {
        // Проверяем, что пользователь авторизован и является членом РАЧ
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Для скачивания публикаций необходимо войти в систему');
        }

        $user = Auth::user();
        
        // Проверяем статус членства (verified_user или admin)
        if (!$user->hasActiveMembership()) {
            return redirect()->route('membership')->with('error', 'Для скачивания публикаций необходимо оплатить членский взнос');
        }

        // Проверяем существование файла
        $filePath = 'publications/' . $publication->id . '/' . $file;
        
        if (!Storage::exists($filePath)) {
            abort(404, 'Файл не найден');
        }

        return Storage::download($filePath);
    }
}
