<?php

namespace App\Http\Controllers;
use App\Services\DatabaseService;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Validation\Rule;

class DatabaseController extends Controller
{
    public function store( Request $request, DatabaseService $databaseService)
    {
        $validated = $request->validate([
            'database_name' => [
                'required',
                'string',
                'max:30',
                'regex:/^[a-zA-Z0-9_]+$/',
            ],

            'charset' => [
                'required',
                Rule::in(config('database_options.charsets'))
            ],

            'collation' => [
                'required',
                Rule::in(config('database_options.collations'))
            ]
        ]);

        try {
            $result = $databaseService->createForUser(
                auth()->user(),
                $validated['database_name'],
                $validated['charset'],
                $validated['collation']
            );

            return redirect()->route('databazy')->with('success', 'Databáza bola vytvorená')->with('databasePassword', $result['password']);

        } catch (Exception $e) {
            return redirect()->route('databazy')->withErrors([
                'database_name' => $e->getMessage(),
            ]);
        }


    }
}
