<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{
    AuthenticationController,
    ServicesApiController,
    WorkerController,
    Locations,
};

use App\Http\Controllers\{
    ProductController,
    ServiceTypeController,
};


Route::post('/login', [AuthenticationController::class, 'login']);

Route::middleware('auth:sanctum')->group( function () {
    Route::post('/update-profile', [AuthenticationController::class, 'update_profile']);
    Route::post('/logout', [AuthenticationController::class, 'logout']);

    // Master Data
    Route::get('/get-service-type', [ServiceTypeController::class, 'index']);
    Route::get('/get-states/{country_id}', [Locations::class, 'get_states']);
    Route::get('/get-cities/{state_id}', [Locations::class, 'get_cities']);

    // User Module
    Route::get('/get-services', [ServicesApiController::class, 'index']);
    Route::get('/services-details/{service_id}', [ServicesApiController::class, 'service_details']);
    Route::post('/book-service', [ServicesApiController::class, 'book_service']);
    Route::get('/get-booked-service', [ServicesApiController::class, 'get_booked_service']);
    Route::post('/cancel-booked-service', [ServicesApiController::class, 'cancel_booked_service']);



    // Worker Module
    Route::get('/get-assign-services', [WorkerController::class, 'get_assign_services']);
    Route::post('/verify-service-otp', [WorkerController::class, 'verify_service_otp']);
    Route::post('/submit-requirement-form', [WorkerController::class, 'submit_requirement_form']);
});