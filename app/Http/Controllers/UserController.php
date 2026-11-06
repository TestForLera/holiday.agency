<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Review;
use App\Models\Favorite;
use App\Models\Package;
use App\Models\Hero;
use App\Models\Service;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $orders = Order::with(['package', 'service', 'review'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();
        $favorites = Favorite::with(['package', 'hero', 'service'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();
        $reviews = Review::where('user_id', $user->id)->latest()->get();

        // Heroes lists for form
        $rostovyeHeroes = [
            'Капибара', 'Куроми', 'Зайка', 'Белый мишка', 'Розовый мишка',
            'Кот', 'Чебурашка', 'Стич', 'Лабубу'
        ];
        $animHeroes = [
            'Карамелька', 'Коржик', 'Лабубу', 'Дед Мороз и Снегурочка',
            'Капи пати', 'Соник', 'Стич', 'Эльза', 'Единорожка',
            'Игра в кальмара', 'Неон пати'
        ];

        return view('user.cabinet', compact('user', 'orders', 'favorites', 'reviews', 'rostovyeHeroes', 'animHeroes'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:30',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return back()->with('success', 'Профиль обновлён!');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Неверный текущий пароль']);
        }

        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return back()->with('success', 'Пароль изменён!');
    }

    public function submitReview(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:2000',
        ]);

        $order = Order::where('id', $validated['order_id'])
            ->where('user_id', auth()->id())
            ->whereIn('status', ['zhdet_otzyva', 'completed'])
            ->firstOrFail();

        if ($order->review) {
            return back()->withErrors(['order_id' => 'Отзыв по этому заказу уже оставлен']);
        }

        Review::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'content' => $validated['comment'],
            'author_name' => auth()->user()->name,
            'category' => 'order',
            'is_published' => true,
        ]);

        $order->update(['status' => 'completed']);

        return back()->with('success', 'Отзыв добавлен! Спасибо!');
    }

    public function createOrder(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'fio' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:30',
            'children_count' => 'required|integer|min:1|max:50',
            'children_ages' => 'required|string|max:255',
            'hero_type' => 'required|in:rostovaya,animaciya',
            'hero_name' => 'required|string|max:100',
            'duration' => 'required|string|max:50',
            'additional' => 'nullable|array',
            'additional.*' => 'in:akvagrim,neon,serebro,express',
            'address' => 'required|string|max:500',
            'apartment' => 'nullable|string|max:50',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|string|max:20',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Check unique date+time
        $exists = Order::where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->whereNotIn('status', ['cancelled'])
            ->exists();
        if ($exists) {
            return back()->withErrors(['date' => 'На эту дату и время уже есть заказ. Выберите другое время.'])->withInput();
        }

        // Validate duration by type
        if ($validated['hero_type'] === 'rostovaya') {
            if ($validated['duration'] !== '15 минут') {
                return back()->withErrors(['duration' => 'Для ростовой куклы доступно только 15 минут (экспресс-поздравление).'])->withInput();
            }
            $allowed = ['Капибара', 'Куроми', 'Зайка', 'Белый мишка', 'Розовый мишка', 'Кот', 'Чебурашка', 'Стич', 'Лабубу'];
            if (!in_array($validated['hero_name'], $allowed)) {
                return back()->withErrors(['hero_name' => 'Недопустимый герой для ростовой куклы.'])->withInput();
            }
        } else {
            $allowedDur = ['15 минут', '30 минут', '45 минут', '1 час', '2 часа'];
            if (!in_array($validated['duration'], $allowedDur)) {
                return back()->withErrors(['duration' => 'Недопустимая длительность.'])->withInput();
            }
            $allowed = ['Карамелька', 'Коржик', 'Лабубу', 'Дед Мороз и Снегурочка', 'Капи пати', 'Соник', 'Стич', 'Эльза', 'Единорожка', 'Игра в кальмара', 'Неон пати'];
            if (!in_array($validated['hero_name'], $allowed)) {
                return back()->withErrors(['hero_name' => 'Недопустимый герой для анимационной программы.'])->withInput();
            }
        }

        // Calculate price
        $price = 0;
        if ($validated['hero_type'] === 'rostovaya') {
            $price = 2550; // express with discount base
            $service = Service::where('title', 'like', '%Экспресс%')->first();
            if ($service) {
                $price = $service->discounted_price ?? $service->price;
            }
        } else {
            $durMap = [
                '15 минут' => 3500,
                '30 минут' => 4000,
                '45 минут' => 4500,
                '1 час' => 5000,
                '2 часа' => 7000,
            ];
            $price = $durMap[$validated['duration']] ?? 4500;
            // apply approx discount
            $price = round($price * 0.88);
        }

        $additional = $validated['additional'] ?? [];
        $addPrice = 0;
        if (in_array('akvagrim', $additional)) {
            if ($validated['children_count'] < 10) {
                $addPrice += 700;
            }
        }
        if (in_array('neon', $additional) || in_array('serebro', $additional)) {
            $addPrice += 1000;
        }
        if (in_array('express', $additional) && $validated['hero_type'] === 'animaciya') {
            $addPrice += 1800;
        }
        $price += $addPrice;

        $order = Order::create([
            'user_id' => $user->id,
            'fio' => $validated['fio'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'children_count' => $validated['children_count'],
            'children_ages' => $validated['children_ages'],
            'hero_type' => $validated['hero_type'],
            'hero_name' => $validated['hero_name'],
            'duration' => $validated['duration'],
            'additional_services' => $additional,
            'address' => $validated['address'],
            'apartment' => $validated['apartment'] ?? null,
            'date' => $validated['date'],
            'time' => $validated['time'],
            'comment' => $validated['comment'] ?? null,
            'status' => 'oformlenie',
            'price' => $price,
        ]);

        return back()->with('success', 'Заявка успешно отправлена! Номер заявки: #' . $order->id);
    }

    public function toggleFavorite(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'nullable|exists:packages,id',
            'hero_id' => 'nullable|exists:heroes,id',
            'service_id' => 'nullable|exists:services,id',
        ]);

        $query = Favorite::where('user_id', auth()->id());

        if (!empty($validated['package_id'])) {
            $query->where('package_id', $validated['package_id']);
        } elseif (!empty($validated['hero_id'])) {
            $query->where('hero_id', $validated['hero_id']);
        } elseif (!empty($validated['service_id'])) {
            $query->where('service_id', $validated['service_id']);
        } else {
            return back()->withErrors(['favorite' => 'Не указан объект избранного']);
        }

        $existing = $query->first();
        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Удалено из избранного');
        }

        Favorite::create(array_merge(['user_id' => auth()->id()], $validated));
        return back()->with('success', 'Добавлено в избранное');
    }

    public function removeFavorite(Favorite $favorite)
    {
        if ($favorite->user_id !== auth()->id()) {
            abort(403);
        }
        $favorite->delete();
        return back()->with('success', 'Удалено из избранного');
    }
}
