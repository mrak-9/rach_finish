<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    public function index()
    {
        // Получаем контент страницы членства
        $membershipPage = StaticPage::where('slug', 'membership')->first();
        
        $user = Auth::user();
        $currentMembership = null;
        $canPayMembership = false;
        
        if ($user) {
            // Получаем текущее активное членство
            $currentMembership = $user->memberships()
                ->where('status', 'paid')
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();
                
            // Проверяем, можно ли оплатить членство
            // Можно оплатить, если нет активного членства или до окончания осталось менее 14 дней
            $canPayMembership = !$currentMembership || 
                ($currentMembership && $currentMembership->end_date->diffInDays(now()) <= 14);
        }

        return view('membership.index', compact('membershipPage', 'currentMembership', 'canPayMembership'));
    }

    public function payment(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Для оплаты членства необходимо войти в систему');
        }

        $request->validate([
            'membership_type' => 'required|in:individual,organization',
            'amount' => 'required|numeric|min:1'
        ]);

        $user = Auth::user();
        
        // Проверяем, можно ли оплатить членство
        $currentMembership = $user->memberships()
            ->where('status', 'paid')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
            
        if ($currentMembership && $currentMembership->end_date->diffInDays(now()) > 14) {
            return redirect()->back()->with('error', 'У вас уже есть активное членство');
        }

        // Определяем период членства
        $startDate = $currentMembership ? $currentMembership->end_date->addDay() : now();
        $endDate = $startDate->copy()->addYear();

        // Создаем запись о членстве
        $membership = $user->memberships()->create([
            'membership_type' => $request->membership_type,
            'amount' => $request->amount,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'pending', // Будет изменен на 'paid' после успешной оплаты
            'payment_method' => 'online',
        ]);

        // В реальном проекте здесь была бы интеграция с платежной системой
        // Для демонстрации сразу помечаем как оплаченное
        $membership->update([
            'status' => 'paid',
            'payment_date' => now(),
            'transaction_id' => 'demo_' . time(),
        ]);

        return redirect()->route('membership')->with('success', 'Членство успешно оплачено!');
    }

    public function generateQR(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'membership_type' => 'required|in:individual,organization',
            'amount' => 'required|numeric|min:1'
        ]);

        // В реальном проекте здесь была бы генерация QR-кода для оплаты
        // Для демонстрации возвращаем заглушку
        $qrData = [
            'payment_url' => route('membership.payment'),
            'amount' => $request->amount,
            'membership_type' => $request->membership_type,
            'user_id' => Auth::id(),
            'qr_code' => 'data:image/svg+xml;base64,' . base64_encode('
                <svg width="200" height="200" xmlns="http://www.w3.org/2000/svg">
                    <rect width="200" height="200" fill="white"/>
                    <rect x="20" y="20" width="160" height="160" fill="black"/>
                    <rect x="40" y="40" width="120" height="120" fill="white"/>
                    <text x="100" y="105" text-anchor="middle" font-family="Arial" font-size="12" fill="black">QR для оплаты</text>
                    <text x="100" y="125" text-anchor="middle" font-family="Arial" font-size="10" fill="black">' . $request->amount . ' руб.</text>
                </svg>
            ')
        ];

        return response()->json($qrData);
    }
}
