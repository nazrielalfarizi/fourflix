<?php

use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;


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
    return redirect('/login');
});


Route::get('/movie', function () {
    $items = Movie::all();
    $username = Auth::user()->name;
return view('movie', [
    'title' => 'Movie',
    'username' => $username,
    'items' => $items
]);
});

Route::get('', function () {
    return redirect('/dashboard');
});

// Route::get('/mylist', function () {
//     return view('mylist', [
//         'title' => 'My List'
//     ]);
// });

Route::get('/profile', function () {
    $email = Auth::user()->email;
    $username = Auth::user()->name;


    return view('profile',[
        'title' => 'Setting',
        'email' => $email,
        'username' => $username
    ]);
});

Route::get('/dashboard', function () {
    $username = Auth::user()->name;
    return view('home', [
        'title' => 'Home',
           'username' => $username
    ]);
})->middleware(['auth'])->name('home');

require __DIR__.'/auth.php';


Route::get('/add', [MovieController::class, 'create']);
Route::post('/add', [MovieController::class, 'store']);
Route::get('/add', function () {
    return view('add', [
        'title' => 'Add'
    ]);
    });


Route::get('/single/{id}', [MovieController::class, 'show']);

Route::get('/edit/{id}', [MovieController::class, 'edit']);
Route::post('/update/{id}', [MovieController::class, 'update']);

Route::get('/delete/{id}', [MovieController::class, 'destroy']);


