<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
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
// Route::get('/hello',function(){
//     return response('<h1>Hello world</h1>',200)
//     ->header('Content-Type', 'text/plain')
//     ->header('foo', 'bar');
// });
// Route::get('/posts/{id}',function($id){
//     //dd($id);
//     return response('Post '.$id);
// })->where ('id','[0-9]+');
// Route::get('/search',function (Request $request){
// return $request->name.' ' .$request->city;
// });

// all listings
Route::get('/', [ListingController::class,'index']);

// single listing idea 1
// Route::get('/listings/{id}', function ($id) {
//     $listing = Listing::find($id);

//     if ($listing) {
//         return view('listing', [
//             'listing' => $listing
//         ]);
//     } else {
//         abort('404');
//     }
// });


//Show create listing
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');
//Store listing
Route::post('/listings',[ListingController::class,'store']);

//show edit form
Route::get('/listings/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');

//update listing
Route::put('/listings/{listing}', [ListingController::class, 'update']);

//manage listing
Route::get('/listings/manage', [ListingController::class, 'manage']);

//update listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

// single listing idea 2(Model binding)
Route::get('/listings/{listing}', [ListingController::class,'show']);

//Register form
Route::get('/register',[UserController::class,'create'])->middleware('guest');

//Store user
Route::post('/users',[UserController::class,'store']);

// Show login user form
Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');

//Authenticate user login
Route::post('/users/authenticate',[UserController::class,'authenticate']);

//Log out user
Route::post('/logout',[UserController::class,'logout'])->middleware('auth');