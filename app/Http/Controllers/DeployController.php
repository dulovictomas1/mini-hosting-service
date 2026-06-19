<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DeployCloneService;
use App\Services\DeployComposerService;
use App\Models\Webspace;
use Exception;
use App\Jobs\DeployCloneJob;
use App\Jobs\DeployComposerJob;

class DeployController extends Controller
{
    public function createClone( Request $request, DeployCloneService $deployCloneService )
    {
        $validated = $request->validate([
            'giturl' => ['required', 'url'],
        ]);

        $webspace = auth()->user()->webspaces()->firstOrFail();
        $path = str_replace('/public', '', $webspace->path);        

        DeployCloneJob::dispatch(
            $path,
            $validated['giturl'],
            $webspace->id,
        );

        return redirect()
            ->route('deploy')
            ->with('success', 'Deploy bol spustený na pozadí.');

        /*try {
            $deployCloneService->clone(
                $path,
                $validated['giturl'],
            );

            return redirect()->route('deploy')->with('success', 'Clon bol úspšne vytvorený');

        } catch (Exception $e) {
            return redirect()->route('deploy')->withErrors($e->getMessage());
        }*/
        
    }

    public function composerInstall( Request $request )
    {
        $webspace = auth()->user()->webspaces()->firstOrFail();
        $path = str_replace('/public', '', $webspace->path);        

        DeployComposerJob::dispatch(
            $path,            
            $webspace->id,
        );

        return redirect()
            ->route('deploy')
            ->with('success', 'Composer Install bol spustený na pozadí.');

    }
}
