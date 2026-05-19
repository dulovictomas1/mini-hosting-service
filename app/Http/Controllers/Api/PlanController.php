<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Plan::select('id', 'name', 'slug', 'database_limit')->get(),
        ]);
    }
}
