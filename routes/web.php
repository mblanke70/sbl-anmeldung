<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $user = Auth::user();
    $schueler = $user->schueler->first();

    return view('sbl', ['schueler' => $schueler]);
})->middleware(['auth']);

Route::post('/reset', function() {

    $schueler = Auth::user()->schueler->first();

    $schueler->buchwahlen()->delete();
    $schueler->delete();
    
    Auth::logout();
    
    return redirect('/');   
});

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

require __DIR__.'/auth.php';
