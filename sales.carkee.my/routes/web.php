<?php

use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/migrate', function() {
	Artisan::call('migrate',['--force' => true ]);
	$result = Artisan::output();
	return response($result);
});
Auth::routes(['register' => false, 'login' => false]);
Route::get('pdf/{id}/{type}', [HomeController::class, 'pdf']);
Route::get('/{any}', function () {
    return view('index');
})->where('any', '.*');
