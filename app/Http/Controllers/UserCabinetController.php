<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserCabinetController extends Controller
{

    public function profile()
    {
        $user = Auth::user();
        return view('cabinet.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'workplace' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'academic_degree' => 'nullable|string|max:255',
        ]);

        $emailChanged = $user->email !== $request->email;
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'city' => $request->city,
            'workplace' => $request->workplace,
            'position' => $request->position,
            'academic_degree' => $request->academic_degree,
        ]);

        if ($emailChanged) {
            $user->email_verified_at = null;
            $user->save();
            $user->sendEmailVerificationNotification();
            
            return redirect()->back()->with('success', 'Профиль обновлен. На новый email отправлено письмо для подтверждения.');
        }

        return redirect()->back()->with('success', 'Профиль успешно обновлен!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Неверный текущий пароль']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Пароль успешно изменен!');
    }

    public function events()
    {
        $user = Auth::user();
        $participations = $user->conferenceParticipations()
            ->with(['conference', 'theses'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('cabinet.events', compact('participations'));
    }

    public function certificates()
    {
        $user = Auth::user();
        $certificates = $user->conferenceParticipations()
            ->with('conference')
            ->where('is_approved', true)
            ->whereHas('conference', function($query) {
                $query->where('conference_date', '<', now());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('cabinet.certificates', compact('certificates'));
    }

    public function membership()
    {
        $user = Auth::user();
        $memberships = $user->memberships()
            ->orderBy('created_at', 'desc')
            ->get();
            
        $currentMembership = $user->memberships()
            ->where('status', 'paid')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        return view('cabinet.membership', compact('memberships', 'currentMembership'));
    }

    public function uploadThesis(Request $request, $participationId)
    {
        $participation = Auth::user()->conferenceParticipations()
            ->findOrFail($participationId);

        // Проверяем, что регистрация на конференцию еще открыта
        if ($participation->conference->conference_date < now()) {
            return redirect()->back()->with('error', 'Конференция уже прошла');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB
            'publish_consent' => 'required|accepted',
        ]);

        $filePath = $request->file('file')->store('theses', 'public');

        $participation->theses()->create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'is_approved' => false,
        ]);

        return redirect()->back()->with('success', 'Тезис успешно загружен!');
    }
}
