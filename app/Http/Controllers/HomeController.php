<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use App\Models\Hero;
use App\Models\Review;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Setting::current();
        $slides = DB::table('slaider')->orderBy('sort_order')->orderBy('id')->get();
        $items = DB::table('items')->orderBy('id', 'asc')->get();
        $reviews = Review::query()
            ->where(function ($q) {
                $q->where('is_published', true)->orWhereNull('is_published');
            })
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        $heroes = Hero::where('is_active', true)->orderBy('sort_order')->get();
        $services = Service::where('is_active', true)->orderBy('order')->get();

        return view('index', [
            'hero_title' => $settings->hero_title ?? 'Поздравление ростовой куклы',
            'hero_subtitle' => $settings->hero_subtitle ?? 'лучший подарок 2025',
            'hero_image' => $settings->hero_image,
            'promo_code' => $settings->promo_code,
            'promo_text' => $settings->promo_text,
            'main_text' => $settings->main_text,
            'why_us_title' => $settings->why_us_title,
            'why_us_text' => $settings->why_us_text,
            'slides' => $slides,
            'items' => $items,
            'reviews' => $reviews,
            'heroes' => $heroes,
            'services' => $services,
            'settings' => $settings,
        ]);
    }

    public function registration()
    {
        return view('registration');
    }
}
