<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class HomeConroller extends Controller
{
    public function index() {
        return view('welcome', [
            'plans' => Plan::all(),
        ]);
    }
}
