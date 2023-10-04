<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Common\CommonController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//
//Auth::routes();
//Auth::routes(['verify' => true]);
//
///*--------------ADMIN ROUTES---------------*/
//Route::group(['middleware' => 'auth', 'prefix' => '/admin', 'namespace' => 'Admin'], function () {
////    Route::group(['middleware'=>'menu_permission'],function(){
//        Route::get('/', 'DashboardController@index')->name('dashboard');
//
//        Route::post('menu/action/status', 'UserMenuActionController@status')->name('user_menu_action.status');
//        Route::get('/menu/action/deleted-list/{menu_id}', 'UserMenuActionController@deletedListIndex')->name('user_menu_action.deleted_list');
//        Route::get('/menu/action/restore/{id}', 'UserMenuActionController@restore')->name('user_menu_action.restore');
//        Route::delete('/menu/action/force-delete/{id}', 'UserMenuActionController@forceDelete')->name('user_menu_action.force_destroy');
//        Route::get('menu/action/{menu_id}', 'UserMenuActionController@index')->name('user_menu_action.index');
//        Route::get('menu/action/create/{menu_id}', 'UserMenuActionController@create')->name('user_menu_action.create');
//        Route::post('menu/action/store/{menu_id}', 'UserMenuActionController@store')->name('user_menu_action.store');
//        Route::get('menu/action/edit/{menu_id}/{id}', 'UserMenuActionController@edit')->name('user_menu_action.edit');
//        Route::delete('menu/action/destroy/{menu_id}/{id}', 'UserMenuActionController@destroy')->name('user_menu_action.destroy');
//        Route::post('menu/action/update/{menu_id}/{id}', 'UserMenuActionController@update')->name('user_menu_action.update');
//
//        Route::post('menu/status', 'MenuController@status')->name('menu.status');
//        Route::get('/menu/deleted-list', 'MenuController@deletedListIndex')->name('menu.deleted_list');
//        Route::get('/menu/restore/{id}', 'MenuController@restore')->name('menu.restore');
//        Route::delete('/menu/force-delete/{id}', 'MenuController@forceDelete')->name('menu.force_destroy');
//        Route::post('/menu/multiple-delete', 'MenuController@multipleDelete')->name('menu.multiple_delete');
//        Route::post('/menu/multiple-restore', 'MenuController@multipleRestore')->name('menu.multiple_restore');
//        Route::resource('menu', 'MenuController');
//
//        Route::post('menu_action/status', 'MenuActionController@status')->name('menu_action.status');
//        Route::get('/menu-action/deleted-list', 'MenuActionController@deletedListIndex')->name('menu_action.deleted_list');
//        Route::get('/menu-action/restore/{id}', 'MenuActionController@restore')->name('menu_action.restore');
//        Route::delete('/menu-action/force-delete/{id}', 'MenuActionController@forceDelete')->name('menu_action.force_destroy');
//        Route::resource('menu_action', 'MenuActionController');
//
//        Route::post('division/status', 'DivisionController@status')->name('division.status');
//        Route::get('/division/deleted-list', 'DivisionController@deletedListIndex')->name('division.deleted_list');
//        Route::get('/division/restore/{id}', 'DivisionController@restore')->name('division.restore');
//        Route::delete('/division/force-delete/{id}', 'DivisionController@forceDelete')->name('division.force_destroy');
//        Route::resource('division', 'DivisionController');
//
//        Route::post('district/status', 'DistrictController@status')->name('district.status');
//        Route::get('/district/deleted-list', 'DistrictController@deletedListIndex')->name('district.deleted_list');
//        Route::get('/district/restore/{id}', 'DistrictController@restore')->name('district.restore');
//        Route::delete('/district/force-delete/{id}', 'DistrictController@forceDelete')->name('district.force_destroy');
//        Route::resource('district', 'DistrictController');
//
//        Route::post('thana/status', 'ThanaController@status')->name('thana.status');
//        Route::get('/thana/deleted-list', 'ThanaController@deletedListIndex')->name('thana.deleted_list');
//        Route::get('/thana/restore/{id}', 'ThanaController@restore')->name('thana.restore');
//        Route::delete('/thana/force-delete/{id}', 'ThanaController@forceDelete')->name('thana.force_destroy');
//        Route::resource('thana', 'ThanaController');
//
//        Route::post('designation/status', 'DesignationController@status')->name('designation.status');
//        Route::get('/designation/deleted-list', 'DesignationController@deletedListIndex')->name('designation.deleted_list');
//        Route::get('/designation/restore/{id}', 'DesignationController@restore')->name('designation.restore');
//        Route::delete('/designation/force-delete/{id}', 'DesignationController@forceDelete')->name('designation.force_destroy');
//        Route::resource('designation', 'DesignationController');
//
//        Route::post('department/status', 'DepartmentController@status')->name('department.status');
//        Route::get('/department/deleted-list', 'DepartmentController@deletedListIndex')->name('department.deleted_list');
//        Route::get('/department/restore/{id}', 'DepartmentController@restore')->name('department.restore');
//        Route::delete('/department/force-delete/{id}', 'DepartmentController@forceDelete')->name('department.force_destroy');
//        Route::resource('department', 'DepartmentController');
//
//        Route::post('employee/status', 'EmployeeController@status')->name('employee.status');
//        Route::get('/employee/deleted-list', 'EmployeeController@deletedListIndex')->name('employee.deleted_list');
//        Route::get('/employee/restore/{id}', 'EmployeeController@restore')->name('employee.restore');
//        Route::delete('/employee/force-delete/{id}', 'EmployeeController@forceDelete')->name('employee.force_destroy');
//        Route::resource('employee', 'EmployeeController');
//
//        Route::post('country/status', 'CountryController@status')->name('country.status');
//        Route::get('/country/deleted-list', 'CountryController@deletedListIndex')->name('country.deleted_list');
//        Route::get('/country/restore/{id}', 'CountryController@restore')->name('country.restore');
//        Route::delete('/country/force-delete/{id}', 'CountryController@forceDelete')->name('country.force_destroy');
//        Route::resource('country', 'CountryController');
//
//        Route::post('role/status', 'RoleController@status')->name('role.status');
//        Route::any('role/permission/{id}', 'RoleController@permission')->name('role.permission');
//        Route::get('/role/deleted-list', 'RoleController@deletedListIndex')->name('role.deleted_list');
//        Route::get('/role/restore/{id}', 'RoleController@restore')->name('role.restore');
//        Route::delete('/role/force-delete/{id}', 'RoleController@forceDelete')->name('role.force_destroy');
//        Route::resource('role', 'RoleController');
//
//        Route::post('user/status', 'UserController@status')->name('user.status');
//        Route::get('user/permission/{id}', 'UserController@permission')->name('user.permission');
//        Route::post('user/permission-update/{id}', 'UserController@permissionUpdate')->name('user.permission_update');
//        Route::post('get_role_permission', 'RoleController@getRolePermission')->name('get_role_permission');
//        Route::get('/profile', 'UserController@profile')->name('user.profile');
//        Route::post('/profile/{id}', 'UserController@profileUpdate')->name('user.profile_update');
//        Route::get('/user/deleted-list', 'UserController@deletedListIndex')->name('user.deleted_list');
//        Route::get('/user/restore/{id}', 'UserController@restore')->name('user.restore');
//        Route::delete('/user/force-delete/{id}', 'UserController@forceDelete')->name('user.force_destroy');
//        Route::resource('user', 'UserController');
//
//        Route::post('content/status', 'ContentController@status')->name('content.status');
//        Route::get('/content/deleted-list', 'ContentController@deletedListIndex')->name('content.deleted_list');
//        Route::get('/content/restore/{id}', 'ContentController@restore')->name('content.restore');
//        Route::delete('/content/force-delete/{id}', 'ContentController@forceDelete')->name('content.force_destroy');
//        Route::resource('content', 'ContentController');
//
//        Route::get('/activity_log/deleted-list', 'ActivityLogController@deletedListIndex')->name('activity_log.deleted_list');
//        Route::get('/activity_log/restore/{id}', 'ActivityLogController@restore')->name('activity_log.restore');
//        Route::delete('/activity_log/force-delete/{id}', 'ActivityLogController@forceDelete')->name('activity_log.force_destroy');
//        Route::resource('activity_log', 'ActivityLogController');
//
//
////        Route::post('/upload-image', 'ImageController@uploadImage')->name('upload_image');
//
//
////    });
//});
//
//Route::group(['middleware' => 'auth'], function () {
//    //common data route here
//    Route::group(['namespace' => 'Common'], function () {
//        //get dependent data
//        Route::post('get_district', [CommonController::class,'GetDistrict'])->name('get_district');
//        Route::post('get_thana', [CommonController::class,'GetThana'])->name('get_thana');
//        Route::post('get_district_from_division', [CommonController::class,'GetDistrictFromDivision'])->name('get_district_from_division');
//        Route::post('get_employee', [CommonController::class,'GetEmployee'])->name('get_employee');
//        Route::post('get_employee_from_pin', [CommonController::class,'GetEmployeeFromPin'])->name('get_employee_from_pin');
//        Route::post('number-validation', [CommonController::class,'NumberValidation'])->name('number_validation');
//        Route::post('/get-districts', [CommonController::class,'GetDistricts'])->name('get_districts');
//        Route::post('/get-thanas', [CommonController::class,'GetThanas'])->name('get_thanas');
//    });
//
//    Route::group(['prefix' => '/admin', 'namespace' => 'Admin'], function () {
//        Route::get('/backup', 'BackupController@index');
//        Route::get('/backup/create', 'BackupController@create');
//        Route::get('/backup/clean', 'BackupController@clean');
//        Route::get('/backup/download/{file_name}', 'BackupController@download');
//        Route::get('/backup/delete/{file_name}', 'BackupController@delete');
//    });
//});
//
//Route::get('/', function () {
//    return redirect(route('login'));
//});
//
///*--------------GENERAL ROUTES---------------*/
//Route::get('contact', [CommonController::class,'contact'])->name('contact');
//Route::any('email_verify', 'Auth\EmailVerifyController@emailVerify')->name('email_verify');
//Route::get('email_verification_check/{email}/{verification_code}', 'Auth\EmailVerifyController@emailVerificationCheck')->name('email_verification_check');
//Route::get('registration_verify/{email}/{verification_code}', 'Auth\RegisterController@registrationVerify')->name('registration_verify');
//
//Route::post('/temp_route', [\App\Http\Controllers\HomeController::class,'null'])->name('temp_route');
