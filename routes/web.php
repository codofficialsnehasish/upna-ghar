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
    ServiceTypeController,
    SliderController,
    CategoryController,
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
            Route::resource('service-type', ServiceTypeController::class);
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
                // Route::get('create','create')->name('service.create');
                Route::get('basic-info','basic_info')->name('service.basic-info');
                Route::post('basic-info-store','basic_info_store')->name('service.basic-info-store');

                Route::get('edit-basic-info/{id}','edit_basic_info')->name('service.edit-basic-info');
                Route::post('edit-basic-info-store','edit_basic_info_store')->name('service.edit-basic-info-store');


                Route::get('edit-price-info/{id?}','edit_price_info')->name('service.edit-price-info');
                Route::post('edit-price-info-store','edit_price_info_store')->name('service.edit-price-info-store');


                Route::get('service-images-edit/{id?}','service_images_edit')->name('service.service-images-edit');
                Route::post('service-gallery-save','serviceGalleryStore')->name('service.service-gallery-save');
                Route::post('get-service-temp-images','serviceTempImages')->name('service.get-service-temp-images');
                Route::post('delete-service-images','delete_service_media')->name('service.delete-service-images');
                Route::post('service-images-process','service_images_process')->name('service.service-images-process');

                Route::get('{id}/edit','edit')->name('service.edit');
                Route::post('update','update')->name('service.update');
                Route::get('{id}/delete','delete')->name('service.delete');

                Route::post('get-sub-category','get_sub_category')->name('service.get-sub-category');
                Route::post('get-sub-parent','get_sub_parent')->name('service.get-sub-parent');
                
                Route::get('{id}/delete-service-media','delete_service_media')->name('service.delete-service-media');
                Route::get('{id}/delete-work-process','delete_work_process')->name('service.delete-work-process');
                Route::get('{id}/delete-promice','delete_promice')->name('service.delete-promice');
            });
        });

        Route::controller(Bookings::class)->group( function () {
            Route::prefix('booking')->group( function () {
                Route::get('','index')->name('booking.index');
                Route::get('today-bookings','today_bookings')->name('booking.today-bookings');
                Route::get('update-booking-status','update_booking_status')->name('booking.update-booking-status');
                Route::get('/{id}/delete','destroy')->name('booking.destroy');

                Route::get('/{id}/show-submitted-details-by-worker','show_submitted_details_by_worker')->name('booking.show-submitted-details-by-worker');
            });
        });

        Route::resource('service-form-template',ServiceFormTemplateController::class);
        Route::get('service-form-template/{id}/delete-form-field',[ServiceFormTemplateController::class,'delete_form_field'])->name('service-form-template.delete-form-field');


        Route::controller(SliderController::class)->group( function () {
            Route::get("/slider","slider")->name('slider');
            Route::get("/slideradd","sliderAdd")->name('slider.add');
            Route::post("/slider_submit","slider_submit")->name('slider.submit');
            Route::get("/slideredit/{id}","sliderEdit")->name('slider.edit');
            Route::post("/slider_edit_submit","slider_edit_submit")->name('slider.edit.submit');
            Route::get("/slider_del/{id}","slider_del")->name('slider.delete');
        });

        Route::resource('category',CategoryController::class);
    });
});