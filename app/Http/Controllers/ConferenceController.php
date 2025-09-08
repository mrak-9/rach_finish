<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConferenceController extends Controller
{
    public function index()
    {
        // Получаем текущую конференцию (если есть)
        $currentConference = Conference::where('registration_start_date', '<=', now())
            ->where('conference_start_date', '>=', now())
            ->orderBy('registration_start_date')
            ->first();

        // Получаем прошедшие конференции, сгруппированные по годам
        $pastConferences = Conference::where('conference_start_date', '<', now())
            ->orderBy('conference_start_date', 'desc')
            ->get()
            ->groupBy(function($conference) {
                return $conference->conference_date->format('Y');
            });

        return view('conferences.index', compact('currentConference', 'pastConferences'));
    }

    public function show(Conference $conference)
    {
        $conference->load(['participants', 'theses']);

        // Проверяем, может ли пользователь зарегистрироваться
        $canRegister = false;
        $registrationMessage = '';

        if (Auth::check()) {
            $user = Auth::user();

            // Проверяем, не зарегистрирован ли уже пользователь
            $existingParticipation = $conference->participants()
                ->where('user_id', $user->id)
                ->first();

            if ($existingParticipation) {
                $registrationMessage = 'Вы уже зарегистрированы на эту конференцию';
            } elseif ($conference->registration_start_date > now()) {
                $registrationMessage = 'Регистрация еще не открыта';
            } elseif ($conference->conference_date < now()) {
                $registrationMessage = 'Конференция уже прошла';
            } else {
                $canRegister = true;
            }
        } else {
            $registrationMessage = 'Для регистрации необходимо войти в систему';
        }

        return view('conferences.show', compact('conference', 'canRegister', 'registrationMessage'));
    }

    public function register(Request $request, Conference $conference)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Для регистрации необходимо войти в систему');
        }

        $user = Auth::user();

        // Проверяем, не зарегистрирован ли уже пользователь
        $existingParticipation = $conference->participants()
            ->where('user_id', $user->id)
            ->first();

        if ($existingParticipation) {
            return redirect()->back()->with('error', 'Вы уже зарегистрированы на эту конференцию');
        }

        // Проверяем даты регистрации
        if ($conference->registration_start_date > now()) {
            return redirect()->back()->with('error', 'Регистрация еще не открыта');
        }

        if ($conference->conference_date < now()) {
            return redirect()->back()->with('error', 'Конференция уже прошла');
        }

        $request->validate([
            'event_date' => 'required|date',
            'participation_format' => 'required|array',
            'participation_format.*' => 'in:online,offline,hybrid'
        ]);

        // Проверяем требования к членству, если необходимо
        $requiresMembership = $conference->events()
            ->where('event_date', $request->event_date)
            ->where('participant_type', 'members_only')
            ->exists();

        if ($requiresMembership && !$user->hasActiveMembership()) {
            return redirect()->route('membership')->with('error', 'Для участия в этой конференции необходимо оплатить членский взнос');
        }

        // Создаем запись об участии
        $conference->participants()->create([
            'user_id' => $user->id,
            'event_date' => $request->event_date,
            'participation_format' => implode(',', $request->participation_format),
            'has_paid_membership' => $user->hasActiveMembership(),
            'is_approved' => true, // По умолчанию одобряем
        ]);

        return redirect()->back()->with('success', 'Вы успешно зарегистрированы на конференцию!');
    }
}
