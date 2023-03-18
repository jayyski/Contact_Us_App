<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\ContactUser;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (Request $request) {
    
    return view('welcome');
    
})->name('contact.view');

Route::post('/contact', function (Request $request) {
    
    $validated = $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required|max:500'
    ]);

    $user = User::create($validated);

    Mail::to($user)->send(new ContactUser($user));

    return redirect()->route('contact.view')->with('success', 'Thanks for contacting us!');
    
})->name('contact.store');
