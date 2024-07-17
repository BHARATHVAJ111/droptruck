<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Dashboard\IndentController;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\DashBoard\CustomerController;
use App\Http\Controllers\Dashboard\SupplierController;
use App\Http\Controllers\Dashboard\VehicleController;
use App\Http\Controllers\Dashboard\SearchController;
use App\Http\Controllers\Dashboard\PricingController;
use App\Http\Controllers\RateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'front']);
Auth::routes();
  
/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:superadmin'])->group(function () {
  
Route::get('api/superadmin/home', [HomeController::class, 'superAdmin'])->name('dashboard');

});
  
/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
  
Route::get('api/admin/home', [HomeController::class, 'admin'])->name('dashboard');
});
  
/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:sales'])->group(function () {
  
 Route::get('api/admin/home/{id}', [HomeController::class, 'sales'])->name('dashboard');

});
  
/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:suppliers'])->group(function () {
  
    Route::get('api/manager/home', [HomeController::class, 'suppliers'])->name('dashboard');
 

});


Route::get('api/employees/create', [EmployeeController::class, 'createmployee'])->name('employees.create');
Route::get('api/employees/index', [EmployeeController::class, 'indexemployee'])->name('employees.index');
Route::post('api/employees', [EmployeeController::class, 'storeemployee'])->name('employees.store');
Route::get('api/employees/{id}/edit', [EmployeeController::class, 'editemployee'])->name('employees.edit');
Route::put('api/employees/{id}/update', [EmployeeController::class, 'updateemployee'])->name('employees.update');
Route::delete('api/employees/{id}/delete', [EmployeeController::class, 'deleteemployee'])->name('employees.destroy');
Route::get('api/employees/{id}', [EmployeeController::class, 'viewemployee'])->name('employees.view');






Route::get('api/customers', [CustomerController::class, 'indexcustomer'])->name('customers.index');
Route::get('api/customers/create', [CustomerController::class, 'createcustomer'])->name('customers.create');
Route::post('api/customers', [CustomerController::class, 'storecustomer'])->name('customers.store');
Route::get('api/customers/{customer}', [CustomerController::class, 'showcustomer'])->name('customers.show');
Route::get('api/customers/{customer}/edit', [CustomerController::class, 'editcustomer'])->name('customers.edit');
Route::put('api/customers/{customer}', [CustomerController::class, 'updatecustomer'])->name('customers.update');
Route::delete('api/customers/{customer}', [CustomerController::class, 'destroycustomer'])->name('customers.destroy');






Route::get('api/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
Route::get('api/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
Route::post('api/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
Route::get('api/suppliers/{id}', [SupplierController::class, 'show'])->name('suppliers.show');
Route::get('api/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
Route::put('api/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
Route::delete('api/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');






Route::get('api/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('api/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
Route::post('api/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
Route::get('api/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');
Route::get('api/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
Route::put('api/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
Route::delete('api/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');


    
Route::get('api/indents', [IndentController::class, 'indexIndent'])->name('indents.index');
Route::get('api/indents/create', [IndentController::class, 'createIndent'])->name('indents.create');
Route::post('api/indents/store', [IndentController::class, 'storeIndent'])->name('indents.store');
Route::get('api/indents/{id}/edit', [IndentController::class, 'editIndent'])->name('indents.edit');
Route::put('api/indents/{id}', [IndentController::class, 'updateIndent'])->name('indents.update');
Route::delete('api/indents/{id}', [IndentController::class, 'destroyIndent'])->name('indents.destroy');
Route::get('api/indents/{indent}', [IndentController::class, 'showIndent'])->name('indents.show');
Route::get('api/indents-list', [IndentController::class, 'indent'])->name('indents.indent');
Route::get('api/dashboard', [IndentController::class, 'enquiry'])->name('indents.dashboard');
Route::get('api/quoted', [IndentController::class, 'quoted'])->name('fetch-last-two-details');
Route::get('api/indent/details', [IndentController::class, 'select'])->name('showIndentDetails');
Route::get('api/confirm/{id}', [IndentController::class, 'confirm'])->name('indents.confirm');
Route::get('api/confirm-to-trips/{id}', [IndentController::class, 'confirmToTrips'])->name('confirm-to-trips');
Route::get('api/cancel-trips/{id}', [IndentController::class,'cancelTrips'])->name('cancel-trips');



Route::get('api/search/customer', [SearchController::class, 'searchCustomer']);
Route::get('api/search/employee', [SearchController::class, 'searchEmployee']);
Route::get('api/search/indent', [SearchController::class, 'searchIndent']);
Route::get('api/search/vehicle', [SearchController::class, 'searchVehicle']);
Route::get('api/search/supplier', [SearchController::class, 'searchSupplier']);
Route::get('api/search/pricing', [SearchController::class, 'searchPricing']);



Route::get('api/rates', [RateController::class, 'indexRate'])->name('rates.index');
Route::get('api/rates/{rate}', [RateController::class, 'showRate'])->name('rates.show');
Route::get('api/rates/{rate}/edit', [RateController::class, 'editRate'])->name('rates.edit');
Route::put('api/rates/{rate}', [RateController::class, 'updateRate'])->name('rates.update');
Route::delete('api/rates/{rate}', [RateController::class, 'destroyRate'])->name('rates.destroy');
Route::get('api/rates/create', [RateController::class, 'createRate'])->name('rates.create');
Route::post('api/rates/store', [RateController::class, 'storeRate'])->name('rates.store');




Route::get('api/pricings', [PricingController::class, 'index'])->name('pricings.index');
Route::get('api/pricings/create', [PricingController::class, 'create'])->name('pricings.create');
Route::post('api/pricings', [PricingController::class, 'store'])->name('pricings.store');
Route::get('api/pricings/{pricing}', [PricingController::class, 'show'])->name('pricings.show');
Route::get('api/pricings/{id}/edit', [PricingController::class, 'edit'])->name('pricings.edit');
Route::put('api/pricings/{id}', [PricingController::class, 'update'])->name('pricings.update');
Route::delete('api/pricings/{pricing}', [PricingController::class, 'destroy'])->name('pricings.destroy');
