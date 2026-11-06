<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Service;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::orderBy('order')->get();
        $services = Service::where('is_active', true)->get();
        return view('admin.packages.index', compact('packages', 'services'));
    }

    public function create()
    {
        $services = Service::where('is_active', true)->get();
        return view('admin.packages.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'original_price' => 'required|numeric|min:0',
            'discounted_price' => 'required|numeric|min:0',
            'discount_percent' => 'required|integer|min:0|max:100',
            'services_json' => 'required|array',
            'is_active' => 'boolean',
            'order' => 'integer'
        ]);

        $validated['services_json'] = json_encode($request->services_json);

        Package::create($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Пакет успешно создан');
    }

    public function edit(Package $package)
    {
        $services = Service::where('is_active', true)->get();
        $package->services_json = json_decode($package->services_json, true);
        return view('admin.packages.edit', compact('package', 'services'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'original_price' => 'required|numeric|min:0',
            'discounted_price' => 'required|numeric|min:0',
            'discount_percent' => 'required|integer|min:0|max:100',
            'services_json' => 'required|array',
            'is_active' => 'boolean',
            'order' => 'integer'
        ]);

        $validated['services_json'] = json_encode($request->services_json);

        $package->update($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Пакет успешно обновлён');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')
            ->with('success', 'Пакет удалён');
    }
}
