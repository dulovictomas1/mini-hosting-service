<?php

namespace App\Http\Controllers;
use App\Models\Plan;

use Illuminate\Http\Request;

class UserPlanController extends Controller
{
    public function store( Request $request )
    {
        $validated = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
        ]);

        $plan = Plan::findOrFail($validated['plan_id']);

        auth()->user()->update([
            'plan_id' => $plan->id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Plán bol úspešne zvolený');
    }
}
