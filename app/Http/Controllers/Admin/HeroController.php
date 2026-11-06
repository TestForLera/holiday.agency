<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function index()
    {
        $heroes = Hero::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.heroes.index', compact('heroes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('heroes', 'public');
        }
        $validated['is_active'] = $request->boolean('is_active', true);

        Hero::create($validated);
        return back()->with('success', 'Герой добавлен!');
    }

    public function update(Request $request, Hero $hero)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($hero->image) {
                Storage::disk('public')->delete($hero->image);
            }
            $validated['image'] = $request->file('image')->store('heroes', 'public');
        }
        $validated['is_active'] = $request->boolean('is_active');

        $hero->update($validated);
        return back()->with('success', 'Герой обновлён!');
    }

    public function destroy(Hero $hero)
    {
        if ($hero->image) {
            Storage::disk('public')->delete($hero->image);
        }
        $hero->delete();
        return back()->with('success', 'Герой удалён!');
    }
}
