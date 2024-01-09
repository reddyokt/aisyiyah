<?php

use App\Http\Controllers\RoleController;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'root']);
// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index']);
// //Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
Route::post('/formsubmit', [App\Http\Controllers\HomeController::class, 'FormSubmit'])->name('FormSubmit');

Route::post('/postlogin', [App\Http\Controllers\AuthenticationController::class, 'postLogin'])->name('authentication.login.post');


Route::group(['middleware' => 'prevent-back-history'], function () {
// Route::group(['middleware'], function () {

    Route::get('login', [App\Http\Controllers\AuthenticationController::class, 'index'])->name('login');

    /* Dashboard */
    Route::group(['middleware' => ['auth:web']], function () {
        Route::get('dashboard', function () {
            return redirect('dashboard/index');
        });
        Route::get('dashboard/index', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('dashboard/setrole/{id}', 'DashboardController@setRole')->name('dashboard.setrole');
        Route::get('set-language/{lang}', 'DashboardController@setLanguage')->name('dashboard.setlanguage');
    });


    /*----------------------------------Master Data-----------------------------------------------------------*/
    /*---------------1.role--------------------------------------*/
    Route::get('/role', [App\Http\Controllers\RoleController::class, 'roleindex']);
    Route::get('/role/add', [App\Http\Controllers\RoleController::class, 'addrole']);
    Route::post('/role/add', [App\Http\Controllers\RoleController::class, 'storenewrole']);
    Route::get('/role/edit/{id}', [App\Http\Controllers\RoleController::class, 'roleedit']);
    Route::post('/role/edit/{id}', [App\Http\Controllers\RoleController::class, 'storeroleedit']);
    /*---------------2.account--------------------------------------*/
    Route::get('/account', [App\Http\Controllers\AccountController::class, 'accountindex']);
    Route::get('/account/create', [App\Http\Controllers\AccountController::class, 'createaccount']);
    Route::post('/account/create', [App\Http\Controllers\AccountController::class, 'storeaccount']);
    Route::get('/account/edit/{id}', [App\Http\Controllers\AccountController::class, 'editaccount']);
    Route::post('/account/edit/{id}', [App\Http\Controllers\AccountController::class, 'updateaccount']);
    Route::get('/account/delete/{id}', [App\Http\Controllers\AccountController::class, 'deleteaccount']);
    Route::get('/account/pda', [App\Http\Controllers\AccountController::class, 'getPDA']);

    /*--------------------3.pda------------------------------------------------*/
    Route::get('/pda', [App\Http\Controllers\PdaController::class, 'pdaindex']);
    Route::get('/pda/create', [App\Http\Controllers\PdaController::class, 'createpda']);
    Route::post('/pda/create', [App\Http\Controllers\PdaController::class, 'storecreatepda']);
    Route::get('/pda/edit/{id}', [App\Http\Controllers\PdaController::class, 'editpda']);
    Route::post('/pda/edit/{id}', [App\Http\Controllers\PdaController::class, 'storeeditpda']);
    Route::post('/pda/delete/{id}', [App\Http\Controllers\PdaController::class, 'deletepda']);
    /*--------------------4.pca------------------------------------------------*/
    Route::get('/pca', [App\Http\Controllers\PcaController::class, 'pcaindex']);
    Route::get('/pca/create', [App\Http\Controllers\PcaController::class, 'createpca']);
    Route::post('/pca/create', [App\Http\Controllers\PcaController::class, 'storecreatepca']);
    Route::get('/pca/edit/{id}', [App\Http\Controllers\PcaController::class, 'editpca']);
    Route::post('/pca/edit/{id}', [App\Http\Controllers\PcaController::class, 'storeeditpca']);
    Route::post('/pca/delete/{id}', [App\Http\Controllers\PcaController::class, 'deletepca']);
    /*------------------5.kader-----------------------------------------------*/
    Route::get('/kader', [App\Http\Controllers\KaderController::class, 'kaderindex']);
    Route::get('/kader/create', [App\Http\Controllers\KaderController::class, 'createkader']);
    Route::post('/kader/create', [App\Http\Controllers\KaderController::class, 'storekader']);
    Route::get('/kader/pcabypda/{id}', [App\Http\Controllers\KaderController::class, 'PCAbyPDA']);
});