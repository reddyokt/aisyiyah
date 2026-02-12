<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LandingPageController,
    HomeController,
    AuthenticationController,
    DashboardController,
    RoleController,
    AccountController,
    PdaController,
    PcaController,
    KaderController,
    MajelisController,
    FiletypeController,
    BidangUsahaController,
    DocumentController,
    SuratController,
    RantingController,
    AumController,
    NewsCategoryController,
    NewsController,
    ProgramKerjaController
};

//
// PUBLIC ROUTES
//
Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/read/post/{news_id}', [LandingPageController::class, 'postBlog'])->name('post.read');

Route::get('index/{locale}', [HomeController::class, 'lang'])->name('lang.set');
Route::post('/formsubmit', [HomeController::class, 'FormSubmit'])->name('form.submit');

//
// AUTH ROUTES (login/logout)
//
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticationController::class, 'index'])->name('login');
    Route::post('/postlogin', [AuthenticationController::class, 'postLogin'])->name('authentication.login.post');
    Route::get('/verified/{token}', [AuthenticationController::class, 'verifiedAccount'])->name('authentication.verifiedAccount');
});

Route::post('/logout', [AuthenticationController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// Landing property admin
Route::prefix('landingproperty')->name('landingproperty.')->group(function () {
    Route::get('/', [LandingPageController::class, 'landingProperty'])->name('index');
    Route::post('/update', [LandingPageController::class, 'updateProperty'])->name('update');
});

// Data PWA
Route::prefix('dataPWA')->name('pwa.')->group(function () {
    Route::get('/', [LandingPageController::class, 'dataPwaNew'])->name('index');
    Route::get('/detail/pda/{id}', [LandingPageController::class, 'dataDetailPda'])->name('detail.pda');
});

//
// PROTECTED ROUTES (WAJIB LOGIN)
//
Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // Dashboard
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', fn() => redirect()->route('dashboard.index'));
        Route::get('/index', [DashboardController::class, 'index'])->name('index');
        Route::get('/setrole/{id}', [DashboardController::class, 'setrole'])->name('setrole');
        Route::get('/set-language/{lang}', [DashboardController::class, 'setlanguage'])->name('setlanguage');
    });

    // MASTER DATA - Role
    Route::prefix('role')->name('role.')->group(function () {
        Route::get('/', [RoleController::class, 'roleIndex'])->name('index');
        Route::get('/create', [RoleController::class, 'addRole'])->name('create');
        Route::post('/', [RoleController::class, 'storeNewRole'])->name('store');
        Route::get('/{id}/edit', [RoleController::class, 'roleEdit'])->name('edit');
        Route::put('/{id}', [RoleController::class, 'storeRoleEdit'])->name('update');
    });

    // Account
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'accountIndex'])->name('index');
        Route::get('/create', [AccountController::class, 'createAccount'])->name('create');
        Route::post('/', [AccountController::class, 'storeAccount'])->name('store');
        Route::get('/{id}/edit', [AccountController::class, 'editAccount'])->name('edit');
        Route::put('/{id}', [AccountController::class, 'updateAccount'])->name('update');
        Route::delete('/{id}', [AccountController::class, 'deleteAccount'])->name('destroy');

        Route::get('/pda', [AccountController::class, 'getPDA'])->name('pda');
        Route::get('/majelis', [AccountController::class, 'getMajelis'])->name('majelis');
        Route::post('/changepassword', [AccountController::class, 'changePassword'])->name('changePassword');
    });

    // PDA
    Route::prefix('pda')->name('pda.')->group(function () {

        // index
        Route::get('/', [PdaController::class, 'pdaIndex'])->name('index');

        // create form
        Route::get('/create', [PdaController::class, 'createPda'])->name('create');

        // ✅ store (recommended REST)
        Route::post('/', [PdaController::class, 'storeCreatePda'])->name('store');

        // ✅ legacy: kalau blade lama action="/pda/create"
        Route::post('/create', [PdaController::class, 'storeCreatePda'])->name('store.legacy');

        // edit form (dua versi: REST + legacy kalau dulu /pda/edit/{id})
        Route::get('/{id}/edit', [PdaController::class, 'editPda'])->name('edit');
        Route::get('/edit/{id}', [PdaController::class, 'editPda'])->name('edit.legacy');

        // update (recommended REST)
        Route::put('/{id}', [PdaController::class, 'updatePda'])->name('update');

        // ✅ legacy: kalau dulu pakai /pda/update/{id}
        Route::put('/update/{id}', [PdaController::class, 'updatePda'])->name('update.legacy');

        // delete (recommended)
        Route::delete('/{id}', [PdaController::class, 'deletePda'])->name('destroy');

        // ✅ legacy: kalau masih ada link GET /pda/delete/{id}
        Route::get('/delete/{id}', [PdaController::class, 'deletePda'])->name('destroy.legacy');
    });


    // PCA
    Route::prefix('pca')->name('pca.')->group(function () {
        // index
        Route::get('/', [PcaController::class, 'pcaIndex'])->name('index');

        // create form
        Route::get('/create', [PcaController::class, 'createPca'])->name('create');

        // ✅ ini yang hilang: store (POST)
        // REST recommended:
        Route::post('/', [PcaController::class, 'storeCreatePca'])->name('store');

        // ✅ kompatibel blade lama yang action="/pca/create"
        Route::post('/create', [PcaController::class, 'storeCreatePca'])->name('store.legacy');

        // edit/update
        Route::get('/{id}/edit', [PcaController::class, 'editPca'])->name('edit');
        Route::put('/{id}', [PcaController::class, 'updatePca'])->name('update');

        // delete (sebaiknya soft delete kalau tabel ada deleted_at)
        Route::delete('/{id}', [PcaController::class, 'deletePca'])->name('destroy');

        // endpoint tambahan kamu
        Route::get('/pdabydistricts/{id}', [PcaController::class, 'pdaBydistricts'])->name('pdabydistricts');

        // legacy delete via GET kalau masih ada link lama
        Route::get('/delete/{id}', [PcaController::class, 'deletePca'])->name('delete.legacy');
    });

    // Ranting
    Route::prefix('ranting')->name('ranting.')->group(function () {

        // index
        Route::get('/', [RantingController::class, 'rantingIndex'])->name('index');

        // create form
        Route::get('/create', [RantingController::class, 'createRanting'])->name('create');

        // store (REST recommended)
        Route::post('/', [RantingController::class, 'storeCreateRanting'])->name('store');

        // legacy: kalau blade lama action="/ranting/create"
        Route::post('/create', [RantingController::class, 'storeCreateRanting'])->name('store.legacy');

        // edit form (REST + legacy)
        Route::get('/{id}/edit', [RantingController::class, 'editRanting'])->name('edit');
        Route::get('/edit/{id}', [RantingController::class, 'editRanting'])->name('edit.legacy');

        // update (REST + legacy)
        Route::put('/{id}', [RantingController::class, 'updateRanting'])->name('update');
        Route::put('/update/{id}', [RantingController::class, 'updateRanting'])->name('update.legacy');

        // destroy (REST)
        Route::delete('/{id}', [RantingController::class, 'deleteRanting'])->name('destroy');

        // legacy: kalau masih ada link GET /ranting/delete/{id}
        Route::get('/delete/{id}', [RantingController::class, 'deleteRanting'])->name('destroy.legacy');

        // endpoints tambahan (lookup)
        Route::get('/pcabyvillages/{id}', [PcaController::class, 'pcaByvillages'])->name('pcabyvillages');
        Route::get('/pcabypdass/{id}', [PcaController::class, 'pcaBypdass'])->name('pcabypdass');
    });

    // Kader
    Route::prefix('kader')->name('kader.')->group(function () {
        Route::get('/', [KaderController::class, 'kaderIndex'])->name('index');
        Route::get('/create', [KaderController::class, 'createKader'])->name('create');
        Route::post('/', [KaderController::class, 'storeKader'])->name('store');

        Route::get('/pcabypda/{id}', [KaderController::class, 'pcaByPda'])->name('pcabypda');
        Route::get('/detail/{id}', [KaderController::class, 'kaderDetail'])->name('detail');
        Route::get('/print/{id}', [KaderController::class, 'kaderPrint'])->name('print');
    });

    // Majelis
    Route::prefix('majelis')->name('majelis.')->group(function () {
        Route::get('/', [MajelisController::class, 'majelisIndex'])->name('index');
        Route::get('/create', [MajelisController::class, 'createMajelis'])->name('create');
        Route::post('/', [MajelisController::class, 'storeCreateMajelis'])->name('store');
    });

    // Filetype
    Route::prefix('filetype')->name('filetype.')->group(function () {
        Route::get('/', [FiletypeController::class, 'filetypeIndex'])->name('index');
        Route::get('/create', [FiletypeController::class, 'createFiletype'])->name('create');
        Route::post('/create', [FiletypeController::class, 'storeCreateFiletype'])->name('store');

        // REST style
        Route::get('/{id}/edit', [FiletypeController::class, 'editFiletype'])->name('edit');
        Route::put('/{id}', [FiletypeController::class, 'updateFiletype'])->name('update');
        Route::delete('/{id}', [FiletypeController::class, 'destroy'])->name('destroy');

        // kompatibel URL lama (biar /filetype/edit/1 & /filetype/delete/1 gak 404)
        Route::get('/edit/{id}', [FiletypeController::class, 'editFiletype'])->name('edit.legacy');
        Route::get('/delete/{id}', [FiletypeController::class, 'destroyViaGet'])->name('delete.legacy');
    });

    // Bidang Usaha
    Route::prefix('bidangusaha')->name('bidangusaha.')->group(function () {
        Route::get('/', [BidangUsahaController::class, 'bidangusahaIndex'])->name('index');
        Route::get('/create', [BidangUsahaController::class, 'createBidangusaha'])->name('create');
        Route::post('/', [BidangUsahaController::class, 'storeCreateBidangusaha'])->name('store');
    });

    Route::prefix('document')->name('document.')->group(function () {
        Route::get('/', [DocumentController::class, 'index'])->name('index');
        Route::get('/create', [DocumentController::class, 'create'])->name('create');
        Route::post('/create', [DocumentController::class, 'store'])->name('store');

        Route::get('/{id}/edit', [DocumentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DocumentController::class, 'update'])->name('update');

        Route::delete('/{id}', [DocumentController::class, 'destroy'])->name('destroy');  // soft delete
        Route::get('/delete/{id}', [DocumentController::class, 'destroyViaGet'])->name('delete.legacy'); // optional
    });

    // Surat
    Route::prefix('surat')->name('surat.')->group(function () {
        Route::get('/create', [SuratController::class, 'createSurat'])->name('create');
        Route::post('/', [SuratController::class, 'storeCreateSurat'])->name('store');

        Route::get('/inbox/{id}', [SuratController::class, 'inbox'])->name('inbox');
        Route::get('/sent/{id}', [SuratController::class, 'sent'])->name('sent');

        Route::get('/inbox/read/{id}', [SuratController::class, 'readInbox'])->name('inbox.read');
        Route::get('/sent/read/{id}', [SuratController::class, 'readSend'])->name('sent.read');
    });

    // AUM
    Route::prefix('aum')->name('aum.')->group(function () {
        Route::get('/', [AumController::class, 'aumIndex'])->name('index');
        Route::get('/create', [AumController::class, 'createAum'])->name('create');
        Route::post('/', [AumController::class, 'storeCreateAum'])->name('store');

        Route::post('/storeimage', [AumController::class, 'storeImage'])->name('storeimage');

        Route::get('/{id}/edit', [AumController::class, 'editAum'])->name('edit');
        Route::put('/{id}', [AumController::class, 'updateAum'])->name('update');
        Route::delete('/{id}', [AumController::class, 'deleteAum'])->name('destroy');

        Route::get('/aumbyranting', [AumController::class, 'aumByRanting'])->name('aumbyranting');
        Route::get('/detail/{id}', [AumController::class, 'aumDetail'])->name('detail');
        Route::get('/aumbypca', [AumController::class, 'aumByPca'])->name('aumbypca');
        Route::get('/aumbypda', [AumController::class, 'aumByPda'])->name('aumbypda');

        Route::get('/pcas/pcasbyrantings/{id}', [AumController::class, 'pcasByrantings'])->name('pcasbyrantings');
        Route::get('/pdas/pdasbyrantings/{id}', [AumController::class, 'pdasByrantings'])->name('pdasbyrantings');
        Route::get('/pdas/pdasbypcass/{id}', [AumController::class, 'pdasBypcass'])->name('pdasbypcass');

        Route::delete('/image', [AumController::class, 'deleteImage'])->name('image.delete');
    });

    // News Category
    Route::prefix('newscategory')->name('newscategory.')->group(function () {
        Route::get('/', [NewsCategoryController::class, 'categoryIndex'])->name('index');
        Route::get('/create', [NewsCategoryController::class, 'createCategory'])->name('create');
        Route::post('/', [NewsCategoryController::class, 'storeCreateCategory'])->name('store');
        Route::get('/{id}/edit', [NewsCategoryController::class, 'editCategory'])->name('edit');
        Route::put('/{id}', [NewsCategoryController::class, 'storeEditCategory'])->name('update');
        Route::delete('/{id}', [NewsCategoryController::class, 'deleteCategory'])->name('destroy');
    });

    // News Posts
    Route::prefix('post')->name('post.')->group(function () {
        Route::get('/', [NewsController::class, 'postIndex'])->name('index');
        Route::get('/create', [NewsController::class, 'createPosty'])->name('create');
        Route::post('/', [NewsController::class, 'storeCreatePost'])->name('store');

        Route::get('/{id}/edit', [NewsController::class, 'editPost'])->name('edit');
        Route::put('/{id}', [NewsController::class, 'storeEditPost'])->name('update');

        Route::delete('/{id}', [NewsController::class, 'deletePost'])->name('destroy');

        Route::get('/validasi/{id}', [NewsController::class, 'validasiPost'])->name('validasi');
        Route::get('/down/{id}', [NewsController::class, 'downPost'])->name('down');
        Route::get('/preview/{id}', [NewsController::class, 'previewPost'])->name('preview');
    });

    // Proker
    Route::prefix('periode')->name('periode.')->group(function () {
        Route::get('/', [ProgramKerjaController::class, 'periodeIndex'])->name('index');
        Route::get('/create', [ProgramKerjaController::class, 'createPeriode'])->name('create');
        Route::post('/', [ProgramKerjaController::class, 'storeCreatePeriode'])->name('store');
        Route::get('/{id}/edit', [ProgramKerjaController::class, 'editPeriode'])->name('edit');
        Route::put('/{id}', [ProgramKerjaController::class, 'storeEditPeriode'])->name('update');
    });

    Route::prefix('proker')->name('proker.')->group(function () {
        Route::get('/', [ProgramKerjaController::class, 'prokerIndex'])->name('index');
        Route::get('/create', [ProgramKerjaController::class, 'createProker'])->name('create');
        Route::post('/', [ProgramKerjaController::class, 'storeCreateProker'])->name('store');

        Route::get('/detail/{id}', [ProgramKerjaController::class, 'prokerDetail'])->name('detail');
        Route::get('/{id}/edit', [ProgramKerjaController::class, 'editProker'])->name('edit');

        Route::get('/validasimda/{id}', [ProgramKerjaController::class, 'validasiMda'])->name('validasimda');
        Route::get('/validasipda/{id}', [ProgramKerjaController::class, 'validasiPda'])->name('validasipda');

        Route::get('/{id}/editdata', [ProgramKerjaController::class, 'updateProker'])->name('editdata');
        Route::put('/{id}', [ProgramKerjaController::class, 'storeUpdate'])->name('update');

        Route::get('/unrealized/{id}', [ProgramKerjaController::class, 'unrealized'])->name('unrealized');
        Route::get('/realized/{id}', [ProgramKerjaController::class, 'realized'])->name('realized');
    });
});
