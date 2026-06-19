<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeConroller;
use App\Http\Controllers\UserPlanController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\WebspaceController;
use App\Http\Controllers\DeployController;
use App\Models\Database;
use App\Models\Plan;
use App\Models\Webspace;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/dashboard', function () {
    return view('dashboard', [
        'plans' => Plan::all(),
        'databases' => auth()->user()->databases,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/dashboard/select-plan', [UserPlanController::class, 'store'])->middleware(['auth', 'verified'])->name('user.plan.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/databazy', function() {
        return view('database_view', [
            'databases' => auth()->user()->databases,
            'charsets' => config('database_options.charsets'),
            'collations' => config('database_options.collations')
        ]);
    })->name('databazy');

    Route::get('/webspace', function () {
        return view('webspace_view', [
            'webspace' => auth()->user()->webspaces
        ]);
    })->name('webspace');

    Route::get('/deploy', function() {
        return view('deploy_view', [
            'webspaces' => auth()->user()->webspaces->first(),
        ]);
    })->name('deploy');
});

require __DIR__.'/auth.php';

Route::get('/', [HomeConroller::class, 'index'])->name('show.index');

Route::post('/databazy/create', [DatabaseController::class, 'store'])->middleware(['auth'])->name('databases.store');
Route::post('/webspace/create', [WebspaceController::class, 'store'])->middleware(['auth'])->name('webspace.store');

Route::post('/gitclone/create', [DeployController::class, 'createClone'])->middleware(['auth'])->name('gitclone.create');

Route::post('/composerinst/create', [DeployController::class, 'composerInstall'])->middleware(['auth'])->name('composerinst.create');

Route::post('/laravelsetup/create', [DeployController::class, 'laravelstup'])->middleware(['auth'])->name('laravelsetup.create');

Route::post('/laravelmigrate/create', [DeployController::class, 'laravelmigrate'])->middleware(['auth'])->name('laravelmigrate.create');

Route::post('/npminstall/create', [DeployController::class, 'npmInstall'])->middleware(['auth'])->name('npminstall.create');

Route::get('/webspace/{webspace}/status', function(App\Models\Webspace $webspace) {
    return response()->json([
        'status' => $webspace->deploy_status,
    ]);
})->middleware('auth');