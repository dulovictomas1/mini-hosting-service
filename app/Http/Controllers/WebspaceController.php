<?php

namespace App\Http\Controllers;

use App\Services\WebspaceService;
use Illuminate\Http\Request;
use Exception;

class WebspaceController extends Controller
{
    public function store(Request $request, WebspaceService $webspaceService)
    {
        $validated = $request->validate([
            'domain' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', 'unique:webspaces,domain'],
        ]);

        try {
            $webspaceService->createForUser(auth()->user(), $validated['domain']);

            return redirect()->route('webspace')->with('success', 'Webspace bol vytvorený');
        } catch (Exception $e) {
            return redirect('webspace')->withErrors([
                'domain' => $e->getMessage(),
            ]);
        }
    }
}
