<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user_controller;
use App\Http\Controllers\admin_controller;
use App\Http\Controllers\sale_controller;
use App\Http\Controllers\authorise_controller;
use App\Http\Controllers\production_controller;
use App\Http\Controllers\dash_sale_controller;
use App\Http\Controllers\dash_production_controller;
use App\Http\Controllers\safety_controller;
use App\Http\Controllers\clinic_controller;
use App\Http\Controllers\geology_controller;
use App\Http\Controllers\employee_controller;
use App\Http\Controllers\control_tower_controller;


Route::post('register', [user_controller::class, 'register']);
Route::post('login', [user_controller::class, 'login']);
Route::get('logout', [user_controller::class, 'logout']);

// Authorization
Route::prefix('auth')->middleware(['auth:api'])->group(function () {
    Route::get('/users', [authorise_controller::class, 'user']);
    Route::get('/auth-access', [authorise_controller::class, 'authAccess']);
    Route::get('/auth-action', [authorise_controller::class, 'authAction']);
    Route::get('/code-menu', [authorise_controller::class, 'codeMenu']);
    Route::get('/code-submenu', [authorise_controller::class, 'codeSubmenu']);
    Route::get('/auth-menu', [authorise_controller::class, 'authMenu']);
    Route::get('/auth-submenu', [authorise_controller::class, 'authSubmenu']);
    Route::post('/add-auth-menu', [authorise_controller::class, 'addAuthMenu']);
    Route::post('/upd-auth-menu', [authorise_controller::class, 'updAuthMenu']);
    Route::post('/add-auth-submenu', [authorise_controller::class, 'addAuthSubmenu']);
    Route::post('/upd-auth-submenu', [authorise_controller::class, 'updAuthSubmenu']);
});

 Route::post('/getauth', [authorise_controller::class, 'authAction']);

// Admin Menu
Route::prefix('admin')->middleware(['auth:api'])->group(function () {
    Route::get('/menu', [admin_controller::class, 'menu']);
    Route::get('/menu-sub', [admin_controller::class, 'menusub']);
    Route::post('/add-menu', [admin_controller::class, 'addMenu']);
    Route::post('/upd-menu', [admin_controller::class, 'updMenu']);
    Route::post('/del-menu', [admin_controller::class, 'delMenu']);
    Route::post('/add-menu-sub', [admin_controller::class, 'addMenusub']);
    Route::post('/upd-menu-sub', [admin_controller::class, 'updMenusub']);
    Route::post('/del-menu-sub', [admin_controller::class, 'delMenusub']);
    Route::get('/emails', [admin_controller::class, 'email']);
    Route::post('/add-email', [admin_controller::class, 'addEmail']);
    Route::post('/upd-email', [admin_controller::class, 'updEmail']);
    Route::post('/del-email', [admin_controller::class, 'delEmail']);
});

// Sales
Route::prefix('sales')->middleware(['auth:api'])->group(function () {
    Route::get('/codes', [sale_controller::class, 'code']);
    Route::post('/add-code', [sale_controller::class, 'addCode']);
    Route::post('/upd-code', [sale_controller::class, 'updCode']);
    Route::post('/del-code', [sale_controller::class, 'delCode']);

    Route::get('/grades', [sale_controller::class, 'grade']);
    Route::post('/add-grade', [sale_controller::class, 'addGrade']);
    Route::post('/upd-grade', [sale_controller::class, 'updGrade']);
    Route::post('/del-grade', [sale_controller::class, 'delGrade']);

    Route::get('/customers', [sale_controller::class, 'customer']);
    Route::post('/add-customer', [sale_controller::class, 'addCustomer']);
    Route::post('/upd-customer', [sale_controller::class, 'updCustomer']);
    Route::post('/del-customer', [sale_controller::class, 'delCustomer']);

    Route::get('/customer-file', [sale_controller::class, 'customerFile']);
    Route::post('/add-customer-file', [sale_controller::class, 'addCustomerFile']);
    Route::post('/del-customer-file', [sale_controller::class, 'delCustomerFile']);
    
    Route::get('/contracts', [sale_controller::class, 'contract']);
    Route::post('/add-contract', [sale_controller::class, 'addContract']);
    Route::post('/upd-contract', [sale_controller::class, 'updContract']);
    Route::post('/del-contract', [sale_controller::class, 'delContract']);
    
    Route::get('/orders', [sale_controller::class, 'order']);
    Route::post('/add-order', [sale_controller::class, 'addOrder']);
    Route::post('/upd-order', [sale_controller::class, 'updOrder']);
    Route::post('/del-order', [sale_controller::class, 'delOrder']);
    
    Route::get('/contract-file', [sale_controller::class, 'contractFile']);
    Route::post('/add-contract-file', [sale_controller::class, 'addContractFile']);
    Route::post('/del-contract-file', [sale_controller::class, 'delContractFile']);
    
    Route::get('/sale-data', [sale_controller::class, 'saleData']);
    Route::get('/sale-year', [sale_controller::class, 'saleYear']);
    
    
    // Route::get('/export-excel', [sale_controller::class, 'ExportTest']);
});

Route::prefix('sales')->controller(sale_controller::class)->group(function(){
    Route::get('/download-customer-file/{file}', 'downloadCustomerFile');
    Route::get('/download-contract-file/{file}', 'downloadContractFile');
});


// Sale dashboard
Route::prefix('dashboard-sale')->middleware(['auth:api'])->group(function () {
    Route::get('/dashboard1', [dash_sale_controller::class, 'dashboard1']);
    Route::get('/dashboard2', [dash_sale_controller::class, 'dashboard2']);
    Route::get('/dashboard3', [dash_sale_controller::class, 'dashboard3']);
    Route::get('/dashboard4', [dash_sale_controller::class, 'dashboard4']);
    Route::get('/dashboard5', [dash_sale_controller::class, 'dashboard5']);
    Route::get('/dashboard6', [dash_sale_controller::class, 'dashboard6']);
    Route::get('/dashboard7', [dash_sale_controller::class, 'dashboard7']);
    Route::get('/dashboard8', [dash_sale_controller::class, 'dashboard8']);
    Route::get('/dashboard9', [dash_sale_controller::class, 'dashboard9']);
    Route::get('/dashboard10', [dash_sale_controller::class, 'dashboard10']);
    Route::get('/last-date', [dash_sale_controller::class, 'lastDate']);
    Route::post('/hide-contract', [dash_sale_controller::class, 'hideContract']);
});

Route::prefix('dashboard-sale')->controller(dash_sale_controller::class)->group(function(){
    Route::post('/hide-contract', 'hideContract');
});
Route::get('/sale-data-export',[sale_controller::class, 'saleDataExport']);

// Production dashboard
Route::prefix('production-dash')->middleware(['auth:api'])->group(function () {
    Route::get('/last-date', [dash_production_controller::class, 'lastDate']);
    Route::get('/dashboard1', [dash_production_controller::class, 'dashboard1']);
    Route::get('/dashboard2', [dash_production_controller::class, 'dashboard2']);
    Route::get('/dashboard3', [dash_production_controller::class, 'dashboard3']);
    Route::get('/dashboard4', [dash_production_controller::class, 'dashboard4']); 
    Route::get('/dashboard5', [dash_production_controller::class, 'dashboard5']);
    Route::get('/dashboard6', [dash_production_controller::class, 'dashboard6']);
    Route::get('/dashboard7', [dash_production_controller::class, 'dashboard7']);
});

// Production
Route::prefix('production')->middleware(['auth:api'])->group(function () {
    Route::get('/mine-production-data', [production_controller::class, 'mineProductionData']);
    Route::get('/mine-year', [production_controller::class, 'mineYear']);
    Route::get('/report1', [production_controller::class, 'report1']);
});

// Geology
Route::prefix('geology')->middleware(['auth:api'])->group(function () {
    Route::get('/sampletickets', [geology_controller::class, 'sampleTicket']);
    Route::post('/add-sampleticket', [geology_controller::class, 'addSampleTicket']);
    Route::post('/del-sampleticket', [geology_controller::class, 'delSampleTicket']);
    Route::post('/upd-sampleticket', [geology_controller::class, 'updSampleTicket']);
});

// Employee
Route::prefix('employee')->middleware(['auth:api'])->group(function () {
    Route::get('/categories', [employee_controller::class, 'category']);
    Route::get('/codes', [employee_controller::class, 'code']);
    Route::get('/rooms', [employee_controller::class, 'room']);

    Route::post('/add-code', [employee_controller::class, 'addCode']);
    Route::post('/upd-code', [employee_controller::class, 'updCode']);
    Route::post('/del-code', [employee_controller::class, 'delCode']);
    Route::post('/add-room', [employee_controller::class, 'addRoom']);
    Route::post('/upd-room', [employee_controller::class, 'updRoom']);
    Route::post('/del-room', [employee_controller::class, 'delRoom']);

});


// Safety
Route::prefix('safety')->middleware(['auth:api'])->group(function () {
    Route::get('/categories', [safety_controller::class, 'category']);
    Route::get('/codes', [safety_controller::class, 'code']);
    Route::post('/add-code', [safety_controller::class, 'addCode']);
    Route::post('/upd-code', [safety_controller::class, 'updCode']);
    Route::post('/del-code', [safety_controller::class, 'delCode']);
    Route::get('/years', [safety_controller::class, 'year']);
    Route::get('/incidents', [safety_controller::class, 'incident']);
    Route::get('/incident-files', [safety_controller::class, 'incidentfile']);
    Route::get('/incident-nextno', [safety_controller::class, 'incidentNextNo']);

    Route::post('/add-incident', [safety_controller::class, 'addIncident']);
    Route::post('/upd-incident', [safety_controller::class, 'updIncident']);
    Route::post('/del-incident', [safety_controller::class, 'delIncident']);
    Route::post('/del-file', [safety_controller::class, 'delFile']);
});

Route::prefix('safety')->controller(safety_controller::class)->group(function(){
    Route::get('/download-incident-file/{file}', 'downloadIncidentFile');
});





// Clinic
Route::prefix('clinic')->middleware(['auth:api'])->group(function () {
    Route::get('/codes', [clinic_controller::class, 'codes']);
    Route::get('/medicines', [clinic_controller::class, 'medicines']);
    Route::post('/add-code', [clinic_controller::class, 'addCode']);
    Route::post('/upd-code', [clinic_controller::class, 'updCode']);
    Route::post('/del-code', [clinic_controller::class, 'delCode']);

    Route::post('/add-patient', [clinic_controller::class, 'addPatient']);


    // Route::get('/mine-year', [production_controller::class, 'mineYear']);
});

  
Route::get('salesdata', [geology_controller::class, 'getSaleData']);











  









// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Control Tower
Route::prefix('control-tower')->group(function () {
    Route::get('/mining', [control_tower_controller::class, 'mining_data']);
});