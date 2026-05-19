<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Webspace;

class WebspaceController extends Controller
{
    public function index( Request $request )
    {
        return response()->json([
            'databases' => $request->user()->webspaces,
        ]);
    }
}
