<?php

use Illuminate\Support\Facades\Route;

//============== Admin Routes =================================
use App\Http\Controllers\{
    Settings,
    AuthController,
    Dashboard,
    RoleController,
    PermissionController,
    UsersController,
    ServiceController,
    PaymentTypeController,
    ApartmentTypeController,
    RoomController,
    TimeSlotController,
    Bookings,
    ServiceFormTemplateController,
};

Route::get('/', function (){
    return redirect(route('login'));
});


//====================== Admin Panel Routes =======================


//======================= Admin Login Routes =====================
Route::controller(AuthController::class)->group( function () {
    Route::get("/login","login")->name("login");
    Route::get("/register-user","register_user");
    Route::post("/changep","change_pass");
    Route::post("/checkuser","checkuser");
    Route::get("/logout","logout");
    Route::get("/changepass","change_password");
});


Route::middleware('auth')->group(function () {
    
    Route::prefix('admin')->group(function () {

        //======================= Admin Dashboard Routes ======================
        Route::get("/dashboard",[Dashboard::class,"dashboard"])->name('dashboard');


        //======================= Settings Routes ======================

        Route::controller(Settings::class)->group(function () {
            Route::get("/settings-contents","content")->name('settings-contents');
            Route::post("/add-content","add_content")->name('settings-contents.add');
        });

        //========================= Roles & Permission =======================

        Route::controller(RoleController::class)->group(function () {
            Route::prefix('role')->group(function () {
                Route::get("/",'roles')->name('roles');
                Route::post("/create-role",'create_role')->name('role.create');
                Route::post("{roleId}/update-role",'update_role')->name('role.update');
                Route::put("/{roleId}/destroy-role",'destroy_role')->name('role.destroy');

                Route::post("/{roleId}/give-permissions",'givePermissionToRole')->name('role.give-permissions');
            });
        });

        Route::controller(PermissionController::class)->group(function () {
            Route::prefix('permission')->group(function () {
                Route::get("/",'permission')->name('permission');
                Route::post("/create-permission",'create_permission')->name('permission.create');
                Route::post("{permissionId}/update-permission",'update_permission')->name('permission.update');
                Route::put("/{permissionId}/destroy-permission",'destroy_permission')->name('permission.destroy');
            });
        });

        //============================== Master Data Routes ===================
        
        Route::prefix('master-data')->group(function () {
            Route::resource('payment-type', PaymentTypeController::class);
            Route::resource('apartment-type', ApartmentTypeController::class);
            Route::resource('room', RoomController::class);
            Route::resource('time-slot', TimeSlotController::class);
        });


        //========================= Users Routes =======================

        Route::controller(UsersController::class)->group(function () {
            Route::prefix('users')->group(function () {
                Route::get('/','index')->name('users');
                Route::get('/workers','workers')->name('workers');
                
                Route::get('/add-new','add_new')->name('users.add');
                Route::post('/add-new/process','process')->name('users.add.process');
                Route::get('/edit/{id}','edit')->name('users.edit');
                Route::post('/update','update_process')->name('users.update');
                Route::get('/delete/{id}','delete')->name('users.delete');
            });
        });


        Route::controller(ServiceController::class)->group( function () {
            Route::prefix('service')->group( function () {
                Route::get('','index')->name('service.index');
                Route::get('create','create')->name('service.create');
                Route::post('store','store')->name('service.store');
                Route::get('{id}/edit','edit')->name('service.edit');
                Route::post('update','update')->name('service.update');
                Route::get('{id}/delete','delete')->name('service.delete');
                Route::post('get-sub-parent','get_sub_parent')->name('service.get-sub-parent');
            });
        });

        Route::controller(Bookings::class)->group( function () {
            Route::prefix('booking')->group( function () {
                Route::get('','index')->name('booking.index');
                Route::get('today-bookings','today_bookings')->name('booking.today-bookings');
                Route::get('update-booking-status','update_booking_status')->name('booking.update-booking-status');
                Route::get('/{id}/delete','destroy')->name('booking.destroy');
            });
        });

        Route::resource('service-form-template',ServiceFormTemplateController::class);

    });
});