<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Отображение списка мероприятий
     */
    public function index(Request $request)
    {
        $pagination = Event::paginate(10);
        
        return view('events.index', [
            'events' => $pagination['data'],
            'pagination' => $pagination
        ]);
    }

    /**
     * Отображение конкретного мероприятия
     */
    public function show(string $slug)
    {
        $event = Event::findBySlug($slug);
        
        if (!$event) {
            abort(404, 'Мероприятие не найдено');
        }

        // Получаем связанные отделения (можно настроить логику)
        $relatedBranches = Branch::limit(3)->get();
        
        return view('events.show', compact('event', 'relatedBranches'));
    }

    /**
     * Административные методы для управления мероприятиями
     */
    
    /**
     * Создание нового мероприятия (для админ панели)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $event = Event::create($request->name);
        $event->updateDescription($request->description);

        // Загружаем изображения если есть
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $caption = $request->input("image_captions.{$index}");
                $event->addImage($image, $caption);
            }
        }

        return redirect()->route('admin.events.index')
                        ->with('success', 'Мероприятие успешно создано');
    }

    /**
     * Обновление мероприятия
     */
    public function update(Request $request, string $slug)
    {
        $event = Event::findBySlug($slug);
        
        if (!$event) {
            abort(404, 'Мероприятие не найдено');
        }

        $request->validate([
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $event->updateDescription($request->description);

        // Добавляем новые изображения если есть
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $caption = $request->input("image_captions.{$index}");
                $event->addImage($image, $caption);
            }
        }

        return redirect()->route('admin.events.show', $slug)
                        ->with('success', 'Мероприятие успешно обновлено');
    }

    /**
     * Удаление мероприятия
     */
    public function destroy(string $slug)
    {
        $event = Event::findBySlug($slug);
        
        if (!$event) {
            abort(404, 'Мероприятие не найдено');
        }

        $event->delete();

        return redirect()->route('admin.events.index')
                        ->with('success', 'Мероприятие успешно удалено');
    }

    /**
     * Удаление изображения из мероприятия
     */
    public function removeImage(Request $request, string $slug)
    {
        $event = Event::findBySlug($slug);
        
        if (!$event) {
            abort(404, 'Мероприятие не найдено');
        }

        $imagePath = $request->input('image_path');
        $event->removeImage($imagePath);

        return response()->json(['success' => true]);
    }

    /**
     * API методы для получения данных
     */
    
    /**
     * API для получения списка мероприятий
     */
    public function apiIndex(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $pagination = Event::paginate($perPage);
        
        return response()->json($pagination);
    }

    /**
     * API для получения конкретного мероприятия
     */
    public function apiShow(string $slug)
    {
        $event = Event::findBySlug($slug);
        
        if (!$event) {
            return response()->json(['error' => 'Мероприятие не найдено'], 404);
        }

        return response()->json([
            'name' => $event->name,
            'slug' => $event->slug,
            'description' => $event->description,
            'short_description' => $event->getShortDescription(),
            'images' => $event->images,
            'preview_image' => $event->getPreviewImage(),
            'slider_images' => $event->getSliderImages(),
            'has_images' => $event->hasImages(),
            'url' => $event->getUrl()
        ]);
    }

    /**
     * API для создания мероприятия (только для авторизованных)
     */
    public function apiStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        try {
            $event = Event::create($request->name);
            $event->updateDescription($request->description);

            return response()->json([
                'message' => 'Мероприятие успешно создано',
                'event' => [
                    'name' => $event->name,
                    'slug' => $event->slug,
                    'url' => $event->getUrl()
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ошибка при создании мероприятия',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API для обновления мероприятия (только для авторизованных)
     */
    public function apiUpdate(Request $request, string $slug)
    {
        $event = Event::findBySlug($slug);
        
        if (!$event) {
            return response()->json(['error' => 'Мероприятие не найдено'], 404);
        }

        $request->validate([
            'description' => 'required|string',
        ]);

        try {
            $event->updateDescription($request->description);

            return response()->json([
                'message' => 'Мероприятие успешно обновлено',
                'event' => [
                    'name' => $event->name,
                    'slug' => $event->slug,
                    'description' => $event->description
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ошибка при обновлении мероприятия',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API для удаления мероприятия (только для авторизованных)
     */
    public function apiDestroy(string $slug)
    {
        $event = Event::findBySlug($slug);
        
        if (!$event) {
            return response()->json(['error' => 'Мероприятие не найдено'], 404);
        }

        try {
            $event->delete();

            return response()->json([
                'message' => 'Мероприятие успешно удалено'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ошибка при удалении мероприятия',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Административные API методы (только для администраторов)
     */
    
    public function apiAdminStore(Request $request)
    {
        // Дополнительная логика для администраторов
        return $this->apiStore($request);
    }

    public function apiAdminUpdate(Request $request, string $slug)
    {
        // Дополнительная логика для администраторов
        return $this->apiUpdate($request, $slug);
    }

    public function apiAdminDestroy(string $slug)
    {
        // Дополнительная логика для администраторов
        return $this->apiDestroy($slug);
    }
}
