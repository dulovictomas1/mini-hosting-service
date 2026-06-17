<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DeployCloneService;
use App\Models\Webspace;
use Exception;

class DeployController extends Controller
{
    public function createClone( Request $request, DeployCloneService $deployCloneService )
    {
        $validated = $request->validate([
            'giturl' => ['required'],
        ]);

        $webspace = auth()->user()->webspaces()->firstOrFail();
        $path = str_replace('/public', '', $webspace->path);        

        try {
            $deployCloneService->clone(
                $path,
                $validated['giturl'],
            );

            return redirect()->route('deploy')->with('success', 'Clon bol úspšne vytvorený');

        } catch (Exception $e) {
            return redirect()->route('deploy')->withErrors($e->getMessage());
        }
        
    }
}
