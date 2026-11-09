<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Package;
use Illuminate\Http\Request;

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

        return view('packages.index', compact('packages'));
    }

    public function order(Request $request, Service $service)
    {
        abort_unless($service->is_active, 404);

        $target = route('cabinet', [
            'section' => 'order-form',
            'service' => $service->id,
        ]);

        if (! auth()->check()) {
            $request->session()->put('url.intended', $target);

            return redirect('/')->with('open_auth', 'login');
        }

        return redirect($target);
    }
}
