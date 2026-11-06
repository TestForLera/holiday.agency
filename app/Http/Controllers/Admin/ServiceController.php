<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceFeature;
use App\Models\Hero;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'duration' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'is_active' => 'boolean',
            'order' => 'integer'
        ]);

        $service = Service::create($validated);

        if ($request->has('features')) {
            foreach ($request->features as $featureText) {
                if (!empty($featureText)) {
                    ServiceFeature::create([
                        'service_id' => $service->id,
                        'feature_text' => $featureText
                    ]);
                }
            }
        }

        if ($request->has('heroes')) {
            foreach ($request->heroes as $heroName) {
                if (!empty($heroName)) {
                    Hero::create([
                        'service_id' => $service->id,
                        'name' => $heroName
                    ]);
                }
            }
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Услуга успешно создана');
    }

    public function edit(Service $service)
    {
        $service->load(['features', 'heroes']);
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'duration' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'is_active' => 'boolean',
            'order' => 'integer'
        ]);

        $service->update($validated);

        ServiceFeature::where('service_id', $service->id)->delete();
        if ($request->has('features')) {
            foreach ($request->features as $featureText) {
                if (!empty($featureText)) {
                    ServiceFeature::create([
                        'service_id' => $service->id,
                        'feature_text' => $featureText
                    ]);
                }
            }
        }

        Hero::where('service_id', $service->id)->delete();
        if ($request->has('heroes')) {
            foreach ($request->heroes as $heroName) {
                if (!empty($heroName)) {
                    Hero::create([
                        'service_id' => $service->id,
                        'name' => $heroName
                    ]);
                }
            }
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Услуга успешно обновлена');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')
            ->with('success', 'Услуга удалена');
    }
}
