<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Package;

class PublicServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)
            ->with(['features', 'heroes'])
            ->orderBy('order')
            ->get();

        return view('services.index', compact('services'));
    }

    public function packages()
    {
        $packages = Package::where('is_active', true)
            ->orderBy('order')
            ->get();

        foreach ($packages as $package) {
            $package->services = Service::findMany(json_decode($package->services_json, true));
        }

        return view('packages.index', compact('packages'));
    }
}
