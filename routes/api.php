<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FestivalController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\FestivalUserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\FestivalFilmController;
use App\Http\Controllers\ViewController;

Route::get('/user', function (Request $request) {  
      return $request->user();
    })->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('list',[AuthController::class,'index']);




// Route::post('/festivals',[FestivalController::class,'store']);
// //Route::get('festivals',[FestivalController::class,'index']);
// //Route::delete('/festivals/{id}',[FestivalController::class,'destroy']);
// //Route::put('/festivals/{id}',[FestivalController::class,'update']);
// Route::get('/festivals/{id}', [FestivalController::class, 'show'])->name('festivals.show');


// //Route::post('/films', [FilmController::class, 'store'])->middleware('auth:sanctum');
// //Route::get('/films', [FilmController::class, 'index']);
// //Route::delete('/films/{id}', [FilmController::class, 'destroy']);
// //Route::put('/films/{id}', [FilmController::class, 'update']);
// Route::get('/films/{id}', [FilmController::class, 'show']);


// Route::post('/plans',[PlanController::class,'store']);
// Route::delete('/plans/{id}',[PlanController::class,'destroy']);
// Route::get('/plans',[PlanController::class,'index']);
// Route::put('/plans/{id}',[PlanController::class,'update']);
// Route::get('/plans/{id}',[PlanController::class,'show']);
// Route::get('/plans/active', [PlanController::class, 'getActivePlans']);




// Route::post('/subscriptions', [SubscriptionController::class, 'store']);
// Route::get('/subscriptions', [SubscriptionController::class, 'index']);
// Route::get('/subscriptions/{id}', [SubscriptionController::class, 'show']); 
// Route::put('/subscriptions/{id}', [SubscriptionController::class, 'update']);
// Route::delete('/subscriptions/{id}', [SubscriptionController::class, 'destroy']); 
// Route::get('/subscriptions/user/{userId}', [SubscriptionController::class, 'getUserSubscriptions']);
// Route::get('/subscriptions/plan/{planId}', [SubscriptionController::class, 'getPlanSubscriptions']);
// Route::get('/subscriptions/active', [SubscriptionController::class, 'getActiveSubscriptions']);
// Route::post('/payments', [PaymentController::class, 'store']);



// Route::get('/payments', [PaymentController::class, 'index']);
// Route::get('/payments/{id}', [PaymentController::class, 'show']);
// Route::put('/payments/{id}', [PaymentController::class, 'update']);
// Route::delete('/payments/{id}', [PaymentController::class, 'destroy']);
// Route::get('/payments/user/{userId}', [PaymentController::class, 'getUserPayments']);


// Route::post('/festival-users', [FestivalUserController::class, 'store']);
// Route::get('/festival-users/{festivalId}/users', [FestivalUserController::class, 'getUsersByFestival']);//done
// Route::get('/festival-users/{userId}/festivals', [FestivalUserController::class, 'getFestivalsByUser']);//done


// Route::post('/festival-films', [FestivalFilmController::class, 'store']);
// Route::get('/festivals/{id}/films', [FestivalFilmController::class, 'showFilms']);
// Route::get('/festival-films/{festivalId}/films', [FestivalFilmController::class, 'getFilmsByFestival']);//done
// Route::get('/festival-films/{filmId}/festivals', [FestivalFilmController::class, 'getFestivalsByFilm']);//done
// Route::get('/festivals/{id}/films/count', [FestivalFilmController::class, 'getCountOfFilmByFestival']);//done


// Route::post('/views', [ViewController::class, 'store']);//done
// Route::get('/views/user/{userId}', [ViewController::class, 'getViewsByUserId']);//done
// Route::get('/views/film/{filmId}', [ViewController::class, 'getViewsByFilmId']);//done
// Route::get('/views/festival/{festivalId}', [ViewController::class, 'getViewsByFestivalId']);//done
// Route::get('/views/plan/{planId}', [ViewController::class, 'getViewsByPlanId']);






// Route::middleware(['auth:sanctum'])->group(function () {

//     // Film routes
//     Route::middleware('role:Admin,Filmmaker')->group(function () {
//         Route::post('/films', [FilmController::class, 'store']);
//         Route::put('/films/{film}', [FilmController::class, 'update']);
//         Route::delete('/films/{film}', [FilmController::class, 'destroy']);
//     });

//     Route::middleware('role:Admin')->post('/films/{film}/accepted', [FilmController::class, 'accepted']);
//     Route::get('/films', [FilmController::class, 'index']); // All roles can view

//     // Festival routes
//     Route::middleware('role:Admin,festival organizer')->group(function () {
//         Route::post('/festivals', [FestivalController::class, 'store']);
//         Route::put('/festivals/{festival}', [FestivalController::class, 'update']);
//         Route::delete('/festivals/{festival}', [FestivalController::class, 'destroy']);
//     });
//     Route::get('/festivals', [FestivalController::class, 'index']); // All roles can view
// });




// Route::middleware(['api'])->group(function () {
//     Route::post('/films', [FilmController::class, 'store']);
// });

//Route::middleware(['auth:sanctum', 'role:admin'])->post('/films/{film}/accepted', [FilmController::class, 'accepted']);


// Route::middleware('role:admin,filmmaker')->group(function () {
//     Route::post('/films', [FilmController::class, 'store']);
// });

// Film routes (only filmmaker + admin)
Route::middleware(['auth:sanctum', 'role:admin,filmmaker'])->group(function (){
    Route::post('/films', [FilmController::class, 'store']);
    Route::put('/films/{film}', [FilmController::class, 'update']);
    Route::delete('/films/{film}', [FilmController::class, 'destroy']);
});

// Accept film (admin only)
Route::middleware('role:admin')->post('/films/{film}/accepted', [FilmController::class, 'accepted']);

// Festival routes (admin + festival organizer)
Route::middleware('role:admin,festival organizer')->group(function () {
    Route::post('/festivals', [FestivalController::class, 'store']);
    Route::put('/festivals/{festival}', [FestivalController::class, 'update']);
    Route::delete('/festivals/{festival}', [FestivalController::class, 'destroy']);
});

Route::get('/festivals', [FestivalController::class, 'index']); // All roles



Route::post('/checkout', [PaymentController::class, 'checkout']); 
