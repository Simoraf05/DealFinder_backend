<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UsersController;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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





//updating status
Route::put('updatingStatus/{id}',[SellerController::class, 'updatingStatus']);
//add feedback
Route::post('addFeedback',[FeedbackController::class, 'addFeedback']);
//add transaction
Route::post('addTransaction',[TransactionController::class, 'addTransaction']);

//Route::post('updateProfile',[UsersController::class, 'updateProfile']);

//addTo cart
Route::post('addToCart',[CartController::class, 'addToCart']);
//show cart
Route::post('getCart', [CartController::class , 'getCart']);
//delete from cart 
Route::delete('deleteFromCart/{cart_id}', [CartController::class , 'deleteFromCart']);



//get commande
Route::post('getCommande',[CommandeController::class ,'getCommande']);




//update password
Route::post('updatePwd',[UsersController::class, 'updatePwd']);
//getMyProducts
Route::post('getMyProducts',[UsersController::class ,'getMyProducts']);
//profile
Route::post('profile',[UsersController::class ,'profile']);
//get all users
Route::get('getUsers',[UsersController::class ,'getUsers']);
//update profil
Route::post('updateProfile/{id}',[UsersController::class, 'updateProfile']);
//delete user
Route::delete('deleteUser/{id}',[UsersController::class, 'deleteUser']);
//filtring users
Route::post('filtreUser',[UsersController::class, 'filtreUser']);




//filtring
Route::get('filtring',[ListingController::class, 'filtring']);
//delete products
Route::delete('deleteProduct/{id}',[ListingController::class, 'deleteProduct']);
//add product
Route::post('AddProduct',[ListingController::class, 'AddProduct']);
//show products
Route::get('getProducts',[ListingController::class, 'getProducts']);
//offersprices
Route::get('getOfferPrices',[ListingController::class, 'getOfferPrices']);
//filtring products
Route::post('filtringData',[ListingController::class, 'filtringData']);
//checkStock
Route::get('checkStock',[ListingController::class ,'checkStock']);
//Myproducts
Route::get('getCategories',[ListingController::class, 'getCategories']);
//getCategory
Route::get('getCategories',[ListingController::class, 'getCategories']);
//update product
Route::post('editeProduct/{id}',[ListingController::class, 'editeProduct']);
//number of  product
Route::post('editeProduct/{id}',[ListingController::class, 'editeProduct']);

//add offer
Route::post('addOffer',[OfferController::class, 'addOffer']);
//update offer price
Route::post('updatingOfferPrice/{id}',[OfferController::class, 'updatingOfferPrice']);
//update offer status
Route::put('updatingOfferStatus/{id}',[OfferController::class, 'updatingOfferStatus']);
//get status updated
Route::post('getStatusUpdated',[OfferController::class, 'getStatusUpdated']);
//offer Detail
Route::post('offer_detail',[OfferController::class, 'offer_detail']);
//update offer
Route::post('updateOffer/{id}',[OfferController::class, 'updateOffer']);
//delete offer
Route::delete('deleteOffer/{id}',[OfferController::class, 'deleteOffer']);
//get my offers
Route::post('getMyOffers',[OfferController::class, 'getMyOffers']);
//update product status
Route::put('updatingProductStatus/{id}',[OfferController::class, 'updatingProductStatus']);

//get rating
Route::get('getRating',[FeedbackController::class, 'getRating']);
//get comments
Route::post('getComments',[FeedbackController::class, 'getComments']);