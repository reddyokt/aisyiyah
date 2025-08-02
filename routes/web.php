<?php

use App\Http\Controllers\PDAController;
use App\Http\Controllers\PCAController;
use App\Http\Controllers\RoleController;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

// Route::get('/', [App\Http\Controllers\HomeController::class, 'root']);
// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index']);
// //Language Translation

Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
Route::post('/formsubmit', [App\Http\Controllers\HomeController::class, 'FormSubmit'])->name('FormSubmit');

Route::post('/postlogin', [App\Http\Controllers\AuthenticationController::class, 'postLogin'])->name('authentication.login.post');
// Route::post('/logout', [App\Http\Controllers\AuthenticationController::class, 'logout']);

Route::get('/', [App\Http\Controllers\LandingPageController::class, 'index']);
// Route::get('/landingpage/post', [App\Http\Controllers\LandingPageController::class, 'postLanding']);
Route::get('/read/post/{news_id}', [App\Http\Controllers\LandingPageController::class, 'postBlog']);


Route::group(['middleware' => 'prevent-back-history'], function () {
// Route::group(['middleware'], function () {

    Route::get('login', [App\Http\Controllers\AuthenticationController::class, 'index'])->name('login');

    /* Dashboard */
    Route::group(['middleware' => ['auth:web']], function () {
        Route::get('dashboard', function () {
            return redirect('dashboard/index');
        });
        Route::get('dashboard/index', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('dashboard/setrole/{id}', [App\Http\Controllers\DashboardController::class, 'setrole'])->name('dashboard.setrole');
        Route::get('set-language/{lang}', [App\Http\Controllers\DashboardController::class, 'setlanguage'])->name('dashboard.setlanguage');
    });


    /*----------------------------------Master Data-----------------------------------------------------------*/
    /*---------------1.role--------------------------------------*/
    Route::get('/role', [App\Http\Controllers\RoleController::class, 'roleIndex']);
    Route::get('/role/add', [App\Http\Controllers\RoleController::class, 'addRole']);
    Route::post('/role/add', [App\Http\Controllers\RoleController::class, 'storeNewRole']);
    Route::get('/role/edit/{id}', [App\Http\Controllers\RoleController::class, 'roleEdit']);
    Route::post('/role/edit/{id}', [App\Http\Controllers\RoleController::class, 'storeRoleEdit']);
    /*---------------2.account--------------------------------------*/
    Route::get('/account', [App\Http\Controllers\AccountController::class, 'accountIndex']);
    Route::get('/account/create', [App\Http\Controllers\AccountController::class, 'createAccount']);
    Route::post('/account/create', [App\Http\Controllers\AccountController::class, 'storeAccount']);
    Route::get('/account/edit/{id}', [App\Http\Controllers\AccountController::class, 'editAccount']);
    Route::post('/account/edit/{id}', [App\Http\Controllers\AccountController::class, 'updateAccount']);
    Route::get('/account/delete/{id}', [App\Http\Controllers\AccountController::class, 'deleteAccount']);
    Route::get('/account/pda', [App\Http\Controllers\AccountController::class, 'getPDA']);
    Route::get('/account/majelis', [App\Http\Controllers\AccountController::class, 'getMajelis']);
    Route::post('/changepassword', [App\Http\Controllers\AccountController::class, 'changePassword']);
    Route::get('verified/{token}', [App\Http\Controllers\AuthenticationController::class, 'verifiedAccount'])->name('authentication.verifiedAccount');

    /*--------------------3.pda------------------------------------------------*/
    Route::get('/pda', [App\Http\Controllers\PdaController::class, 'pdaIndex'])->name('pdaIndex');
    Route::get('/pda/create', [App\Http\Controllers\PdaController::class, 'createPda']);
    Route::post('/pda/create', [App\Http\Controllers\PdaController::class, 'storeCreatePda']);
    Route::get('/pda/edit/{id}', [App\Http\Controllers\PdaController::class, 'editPda']);
    Route::put('/pda/update/{id}', [App\Http\Controllers\PdaController::class, 'updatePda']);
    Route::post('/pda/delete/{id}', [App\Http\Controllers\PdaController::class, 'deletePda']);
    /*--------------------4.pca------------------------------------------------*/
    Route::get('/pca', [App\Http\Controllers\PcaController::class, 'pcaIndex']);
    Route::get('/pca/create', [App\Http\Controllers\PcaController::class, 'createPca']);
    Route::post('/pca/create', [App\Http\Controllers\PcaController::class, 'storeCreatePca']);
    Route::get('/pca/edit/{id}', [App\Http\Controllers\PcaController::class, 'editPca']);
    Route::post('/pca/edit/{id}', [App\Http\Controllers\PcaController::class, 'storeEditPca']);
    Route::put('/pca/update/{id}', [App\Http\Controllers\PcaController::class, 'updatePca']);
    Route::get('/pca/pdabydistricts/{id}', [App\Http\Controllers\PcaController::class, 'pdaBydistricts']);
    /*------------------5.kader-----------------------------------------------*/
    Route::get('/kader', [App\Http\Controllers\KaderController::class, 'kaderIndex']);
    Route::get('/kader/create', [App\Http\Controllers\KaderController::class, 'createKader']);
    Route::post('/kader/create', [App\Http\Controllers\KaderController::class, 'storeKader']);
    Route::get('/kader/pcabypda/{id}', [App\Http\Controllers\KaderController::class, 'pcaByPda']);
    Route::get('/kader/detail/{id}', [App\Http\Controllers\KaderController::class, 'kaderDetail']);
    Route::get('/kader/print/{id}', [App\Http\Controllers\KaderController::class, 'kaderPrint']);
    /*------------------6.majelis-----------------------------------------------*/
    Route::get('/majelis', [App\Http\Controllers\MajelisController::class, 'majelisIndex']);
    Route::get('/majelis/create', [App\Http\Controllers\MajelisController::class, 'createMajelis']);
    Route::post('/majelis/create', [App\Http\Controllers\MajelisController::class, 'storeCreateMajelis']);
    /*------------------7.filetype-----------------------------------------------*/
    Route::get('/filetype', [App\Http\Controllers\FiletypeController::class, 'filetypeIndex']);
    Route::get('/filetype/create', [App\Http\Controllers\FiletypeController::class, 'createFiletype']);
    Route::post('/filetype/create', [App\Http\Controllers\FiletypeController::class, 'storeCreateFiletype']);
    /*------------------7.bidang_usaha-----------------------------------------------*/
    Route::get('/bidangusaha', [App\Http\Controllers\BidangUsahaController::class, 'bidangusahaIndex']);
    Route::get('/bidangusaha/create', [App\Http\Controllers\BidangUsahaController::class, 'createBidangusaha']);
    Route::post('/bidangusaha/create', [App\Http\Controllers\BidangUsahaController::class, 'storeCreateBidangusaha']);
    /*------------------8.Document-----------------------------------------------*/
    Route::get('/document', [App\Http\Controllers\DocumentController::class, 'documentIndex']);
    Route::get('/document/create', [App\Http\Controllers\DocumentController::class, 'createDocument']);
    Route::post('/document/create', [App\Http\Controllers\DocumentController::class, 'storeCreateDocument']);
    /*------------------8.Surat-----------------------------------------------*/
    Route::get('/inbox/{id}', [App\Http\Controllers\SuratController::class, 'inbox']);
    Route::get('/sent/{id}', [App\Http\Controllers\SuratController::class, 'sent']);
    Route::get('/surat/create', [App\Http\Controllers\SuratController::class, 'createSurat']);
    Route::post('/surat/create', [App\Http\Controllers\SuratController::class, 'storeCreateSurat']);
    Route::get('/inbox/read/{id}', [App\Http\Controllers\SuratController::class, 'readInbox']);
    Route::get('/sent/read/{id}', [App\Http\Controllers\SuratController::class, 'readSend']);
    Route::get('/inbox/read/{id}', [App\Http\Controllers\SuratController::class, 'readSurat']);

    /*------------------9.ranting-----------------------------------------------*/
    Route::get('/ranting', [App\Http\Controllers\RantingController::class, 'rantingIndex']);
    Route::get('/ranting/create', [App\Http\Controllers\RantingController::class, 'createRanting']);
    Route::post('/ranting/create', [App\Http\Controllers\RantingController::class, 'storeCreateRanting']);
    Route::get('/ranting/edit/{id}', [App\Http\Controllers\RantingController::class, 'editRanting']);
    Route::put('/ranting/update/{id}', [App\Http\Controllers\RantingController::class, 'updateRanting']);
    Route::post('/ranting/delete/{id}', [App\Http\Controllers\RantingController::class, 'deleteRanting']);
    Route::get('/ranting/pcabyvillages/{id}', [App\Http\Controllers\PcaController::class, 'pcaByvillages']);
    Route::get('/ranting/pcabypdass/{id}', [App\Http\Controllers\PcaController::class, 'pcaBypdass']);
    /*------------------10.AUM-----------------------------------------------*/
    Route::get('/aum', [App\Http\Controllers\AumController::class, 'aumIndex']);
    Route::get('/aum/create', [App\Http\Controllers\AumController::class, 'createAum']);
    Route::post('/aum/create', [App\Http\Controllers\AumController::class, 'storeCreateAum']);
    Route::post('/aum/storeimage', [App\Http\Controllers\AumController::class, 'storeImage']);
    Route::get('/aum/edit/{id}', [App\Http\Controllers\Aumcontroller::class, 'editAum']);
    Route::post('/aum/edit/{id}', [App\Http\Controllers\AumController::class, 'storeEditAum']);
    Route::post('/aum/delete/{id}', [App\Http\Controllers\AumController::class, 'deleteAum']);
    Route::get('/aum/aumbyranting', [App\Http\Controllers\AumController::class, 'aumByRanting']);
    Route::get('/aum/detail/{id}', [App\Http\Controllers\AumController::class, 'aumDetail']);
    Route::get('/aum/aumbypca', [App\Http\Controllers\AumController::class, 'aumByPca']);
    Route::get('/aum/aumbypda', [App\Http\Controllers\AumController::class, 'aumByPda']);
    Route::get('/pcas/pcasbyrantings/{id}', [App\Http\Controllers\AumController::class, 'pcasByrantings']);
    Route::get('/pdas/pdasbyrantings/{id}', [App\Http\Controllers\AumController::class, 'pdasByrantings']);
    Route::get('/pdas/pdasbypcass/{id}', [App\Http\Controllers\AumController::class, 'pdasBypcass']);
    /*------------------11.News-----------------------------------------------*/
    Route::get('/newscategory', [App\Http\Controllers\NewsCategoryController::class, 'categoryIndex']);
    Route::get('/newscategory/create', [App\Http\Controllers\NewsCategoryController::class, 'createCategory']);
    Route::post('/newscategory/create', [App\Http\Controllers\NewsCategoryController::class, 'storeCreateCategory']);
    Route::get('/newscategory/edit/{id}', [App\Http\Controllers\NewsCategoryController::class, 'editCategory']);
    Route::post('/newscategory/edit/{id}', [App\Http\Controllers\NewsCategoryController::class, 'storeEditCategory']);
    Route::post('/newscategory/delete/{id}', [App\Http\Controllers\NewsCategoryController::class, 'deleteCategory']);

    Route::get('/post', [App\Http\Controllers\NewsController::class, 'postIndex']);
    Route::get('/post/add', [App\Http\Controllers\NewsController::class, 'createPosty']);
    Route::post('/post/create', [App\Http\Controllers\NewsController::class, 'storeCreatePost']);
    Route::get('/post/edit/{id}', [App\Http\Controllers\NewsController::class, 'editPost']);
    Route::post('/post/edit/{id}', [App\Http\Controllers\NewsController::class, 'storeEditPost']);
    Route::post('/post/delete/{id}', [App\Http\Controllers\NewsController::class, 'deletePost']);
    Route::get('validasiPost/{id}', [App\Http\Controllers\NewsController::class, 'validasiPost']);
    Route::get('downPost/{id}', [App\Http\Controllers\NewsController::class, 'downPost']);
    Route::get('post/preview/{id}', [App\Http\Controllers\NewsController::class, 'previewPost']);

     /*------------------12.Proker-----------------------------------------------*/
     Route::get('/periode', [App\Http\Controllers\ProgramKerjaController::class, 'periodeIndex']);
     Route::get('/periode/create', [App\Http\Controllers\ProgramKerjaController::class, 'createPeriode']);
     Route::post('/periode/create', [App\Http\Controllers\ProgramKerjaController::class, 'storeCreatePeriode']);
     Route::get('/periode/edit/{id}', [App\Http\Controllers\ProgramKerjaController::class, 'editPeriode']);
     Route::post('/periode/edit/{id}', [App\Http\Controllers\ProgramKerjaController::class, 'storeEditPeriode']);

     Route::get('/proker', [App\Http\Controllers\ProgramKerjaController::class, 'prokerIndex']);
     Route::get('/proker/create', [App\Http\Controllers\ProgramKerjaController::class, 'createProker']);
     Route::post('/proker/create', [App\Http\Controllers\ProgramKerjaController::class, 'storeCreateProker']);
     Route::get('/proker/detail/{id}', [App\Http\Controllers\ProgramKerjaController::class, 'prokerDetail']);
     Route::get('/proker/edit/{id}', [App\Http\Controllers\ProgramKerjaController::class, 'editProker']);
     Route::get('/proker/edit/{id}', [App\Http\Controllers\ProgramKerjaController::class, 'editProker']);
     Route::get('/proker/validasimda/{id}', [App\Http\Controllers\ProgramKerjaController::class, 'validasiMda']);
     Route::get('/proker/validasipda/{id}', [App\Http\Controllers\ProgramKerjaController::class, 'validasiPda']);
     Route::get('/proker/update/{id}', [App\Http\Controllers\ProgramKerjaController::class, 'updateProker']);
     Route::post('/proker/update/{id}', [App\Http\Controllers\ProgramKerjaController::class, 'storeUpdate']);
     Route::get('/proker/unrealized/{id}', [App\Http\Controllers\ProgramKerjaController::class, 'unrealized']);
     Route::get('/proker/realized/{id}', [App\Http\Controllers\ProgramKerjaController::class, 'realized']);


     /*------------------13.Landing Property-----------------------------------------------*/
     Route::get('/landingproperty', [App\Http\Controllers\LandingPageController::class, 'landingProperty']);
     Route::post('/landingprop/update', [App\Http\Controllers\LandingPageController::class, 'updateProperty']);

     /*------------------14.Data PWA-----------------------------------------------*/
     Route::get('/dataPWA', [App\Http\Controllers\LandingPageController::class, 'dataPwaNew']);
     Route::get('/dataPWANew', [App\Http\Controllers\LandingPageController::class, 'dataPwaNew']);
     Route::get('/detail/pda/{id}', [App\Http\Controllers\LandingPageController::class, 'dataDetailPda']);


     

});
