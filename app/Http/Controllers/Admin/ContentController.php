<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class ContentController extends Controller
{
    public function edit()
    {
        $settings = Setting::current();
        $slides = DB::table('slaider')->orderBy('sort_order')->orderBy('id')->get();

        return view('admin.content.edit', compact('settings', 'slides'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'promo_code' => 'nullable|string|max:50',
            'promo_text' => 'nullable|string|max:255',
            'main_text' => 'nullable|string|max:255',
            'why_us_title' => 'nullable|string|max:255',
            'why_us_text' => 'nullable|string',
            'hero_image' => 'nullable|image|max:4096',
        ]);

        $settings = Setting::current();

        if ($request->hasFile('hero_image')) {
            if ($settings->hero_image) {
                Storage::disk('public')->delete($settings->hero_image);
            }
            $validated['hero_image'] = $request->file('hero_image')->store('heroes', 'public');
        } else {
            unset($validated['hero_image']);
        }

        $settings->update($validated);

        return back()->with('success', 'Контент главной страницы обновлён!');
    }

    public function storeSlide(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'nullable|string',
            'image' => 'required|image|max:4096',
            'sort_order' => 'nullable|integer',
        ]);

        $path = $request->file('image')->store('slides', 'public');

        DB::table('slaider')->insert([
            'title' => $validated['title'],
            'text' => $validated['text'] ?? null,
            'image_path' => $path,
            'sort_order' => $validated['sort_order'] ?? 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Слайд добавлен!');
    }

    public function updateSlide(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            'sort_order' => 'nullable|integer',
        ]);

        $slide = DB::table('slaider')->where('id', $id)->first();
        if (!$slide) {
            return back()->withErrors(['slide' => 'Слайд не найден']);
        }

        $data = [
            'title' => $validated['title'],
            'text' => $validated['text'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'updated_at' => now(),
        ];

        if ($request->hasFile('image')) {
            if ($slide->image_path) {
                Storage::disk('public')->delete($slide->image_path);
            }
            $data['image_path'] = $request->file('image')->store('slides', 'public');
        }

        DB::table('slaider')->where('id', $id)->update($data);

        return back()->with('success', 'Слайд обновлён!');
    }

    public function destroySlide($id)
    {
        $slide = DB::table('slaider')->where('id', $id)->first();
        if ($slide) {
            if ($slide->image_path) {
                Storage::disk('public')->delete($slide->image_path);
            }
            DB::table('slaider')->where('id', $id)->delete();
        }
        return back()->with('success', 'Слайд удалён!');
    }
}
