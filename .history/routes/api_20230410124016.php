<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//authentification
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
});

//add product
Route::post('addProduct',[ListingController::class, 'AddProduct']);
//show products
Route::get('getProducts',[ListingController::class, 'getProducts']);
//delete products
Route::delete('deleteProduct/{id}',[ListingController::class, 'deleteProduct']);
//add offer
Route::post('addOffer',[OfferController::class, 'addOffer']);
//update offer price
Route::put('updatingOfferPrice/{id}',[OfferController::class, 'updatingOfferPrice']);
//update offer status
Route::put('updatingOfferStatus/{id}',[OfferController::class, 'updatingOfferStatus']);
//get status updated
Route::post('getStatusUpdated',[OfferController::class, 'getStatusUpdated']);
//updating status
Route::put('updatingStatus/{id}',[SellerController::class, 'updatingStatus']);
//add feedback
Route::post('addFeedback',[FeedbackController::class, 'addFeedback']);
//add transaction
Route::post('addTransaction',[TransactionController::class, 'addTransaction']);
//update profil
Route::post('updateProfile/{id}',[UsersController::class, 'updateProfile']);
//Route::post('updateProfile',[UsersController::class, 'updateProfile']);
//Myproducts
Route::get('getCategories',[ListingController::class, 'getCategories']);
//getCategory
Route::get('getCategories',[ListingController::class, 'getCategories']);
//update product
Route::post('editeProduct/{id}',[ListingController::class, 'editeProduct']);
//addTo cart
Route::post('addToCart',[CartController::class, 'addToCart']);
//show cart
Route::post('getCart', [CartController::class , 'getCart']);
//delete from cart 
Route::delete('deleteFromCart/{cart_id}', [CartController::class , 'deleteFromCart']);
//get my offers
Route::post('getMyOffers',[OfferController::class, 'getMyOffers']);
//update
//Route::post('deleteFromCart', [CartController::class , 'deleteFromCart']);
