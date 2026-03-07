<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DivisionController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('divisions', DivisionController::class);
Route::get('divisions/{id}/subdivisions', [DivisionController::class, 'subdivisions']);

Route::post('/seed-divisions', function () {
    try {

        \App\Models\Division::truncate();

        Artisan::call('db:seed', [
            '--class' => 'DivisionSeeder',
            '--force' => true
        ]);

        return response()->json([
            'message' => 'Divisions reseeded successfully'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'error' => $e->getMessage()
        ], 500);

    }
});
