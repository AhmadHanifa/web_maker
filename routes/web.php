<?php
# Backend Controllers

use App\Http\Controllers\Api\AboutUsApiController;
use App\Http\Controllers\Api\CardsApiController;
use App\Http\Controllers\Api\ClientsApiController;
use App\Http\Controllers\Api\OurSolutionApiController;
use App\Http\Controllers\Api\ServicesApiController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\BackendAdminController;
use App\Http\Controllers\Backend\BackendNotificationsController;
use App\Http\Controllers\Backend\BackendHelperController;
use App\Http\Controllers\Backend\BackendTestController;
use App\Http\Controllers\Backend\BackendProfileController;
use App\Http\Controllers\Backend\BackendArticleController;
use App\Http\Controllers\Backend\BackendArticleCommentController;
use App\Http\Controllers\Backend\BackendSiteMapController;
use App\Http\Controllers\Backend\BackendSettingController;
use App\Http\Controllers\Backend\BackendContactController;
use App\Http\Controllers\Backend\BackendCategoryController;
use App\Http\Controllers\Backend\BackendRedirectionController;
use App\Http\Controllers\Backend\BackendUserController;
use App\Http\Controllers\Backend\BackendTrafficsController;
use App\Http\Controllers\Backend\BackendPageController;
use App\Http\Controllers\Backend\BackendMenuController;
use App\Http\Controllers\Backend\BackendMenuLinkController;
use App\Http\Controllers\Backend\BackendFileController;
use App\Http\Controllers\Backend\BackendFaqController;
use App\Http\Controllers\Backend\BackendContactReplyController;
use App\Http\Controllers\Backend\BackendAnnouncementController;
use App\Http\Controllers\Backend\BackendPermissionController;
use App\Http\Controllers\Backend\BackendUserPermissionController;
use App\Http\Controllers\Backend\BackendUserRoleController;
use App\Http\Controllers\Backend\BackendRoleController;
use App\Http\Controllers\Backend\BackendTagController;
use App\Http\Controllers\Backend\BackendPluginController;
use App\Http\Controllers\Backend\BackendUserwebsiteController;
use App\Http\Controllers\Backend\frontEndController\GetSearchedController;
use App\Http\Controllers\Backend\frontEndController\ApiController;
use App\Http\Controllers\back\ServicesController;
use App\Http\Controllers\back\AboutUsController;
use App\Http\Controllers\back\CardsController;
use App\Http\Controllers\back\ClientsController;
use App\Http\Controllers\back\ContactUsController;
use App\Http\Controllers\back\SliderController;
use App\Http\Controllers\back\OurSolutionController;
use App\Http\Controllers\Backend\BackendMessageController;
use App\Http\Controllers\Backend\frontEndController\indexController;
# Frontend Controllers
use App\Http\Controllers\FrontController;
use App\Http\Controllers\FrontendProfileController;
use App\Http\Controllers\PageGeneratorController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

Auth::routes();
Route::get('/index3', function(){return view('front.index3');})->name('index3');



//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize:clear');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});



// post_type
Route::get('/makeemail', function () {

    Artisan::call('optimize');
    return 'cache cache has clear successfully !';
});

############################################# Form add Subcripe ######################################################

Route::post('/store/data', [BackendUserwebsiteController::class,'store'])->name('store.data');
Route::match(['get' , 'post'],'/edit/data/{id}', [BackendUserwebsiteController::class,'edit'])->name('edit.data');
Route::post('/update/data/{id}', [BackendUserwebsiteController::class,'update'])->name('update.data');
Route::post('/destroy/data/{id}', [BackendUserwebsiteController::class,'destroy'])->name('destroy.data');
// Route::post('/store', [BackendUserwebsiteController::class,'store'])->name('edit.data');


############################################# End Form add Subcripe ######################################################
Route::get('page/search/', [GetSearchedController::class,'search'])->name('search');
Route::get('search/', [GetSearchedController::class,'DoSearchDB'])->name('searchDB');
Route::get('details/{id}/{name}', [indexController::class,'show'])->name('showMore');
Route::get('valid/page.html/', [GetSearchedController::class,'searchValid'])->name('moveValidd');
Route::get('validd/', [GetSearchedController::class,'validating'])->name('vald');


Route::get('success/', function(){
  return view('Frontend.successfully');
});

// Route::get('/', [FrontController::class,'index'])->name('home');
Route::get('/index2', function(){return view('front.index2');})->name('index2');



Route::prefix('dashboard')->middleware(['auth','ActiveAccount','verified'])->name('user.')->group(function () {
    Route::get('/', [FrontendProfileController::class,'dashboard'])->name('dashboard');
    Route::get('/support', [FrontendProfileController::class,'support'])->name('support');
    Route::get('/support/create-ticket', [FrontendProfileController::class,'create_ticket'])->name('create-ticket');
    Route::post('/support/create-ticket', [FrontendProfileController::class,'store_ticket'])->name('store-ticket');
    Route::get('/support/{ticket}', [FrontendProfileController::class,'ticket'])->name('ticket');
    Route::post('/support/{ticket}/reply', [FrontendProfileController::class,'reply_ticket'])->name('reply-ticket');
    Route::get('/notifications', [FrontendProfileController::class,'notifications'])->name('notifications');
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/settings',[FrontendProfileController::class,'profile_edit'])->name('edit');
        Route::put('/update',[FrontendProfileController::class,'profile_update'])->name('update');
        Route::put('/update-password',[FrontendProfileController::class,'profile_update_password'])->name('update-password');
        Route::put('/update-email',[FrontendProfileController::class,'profile_update_email'])->name('update-email');
    });
});
    Route::get('updateStatusForAllUsers',[BackendUserwebsiteController::class,'updateStatusForAllUsers'])->name('updateStatusForAllUsers');
Route::get('usersWebsite/functionshowDetailsUserWebsite/{id}',[BackendUserwebsiteController::class,'functionshowDetailsUserWebsite'])->name('functionshowDetailsUserWebsite');

#Route::get('/test',[BackendTestController::class,'test']);

Route::prefix('admin')->middleware(['auth','ActiveAccount'])->name('admin.')->group(function () {


    Route::get('/',[BackendAdminController::class,'index'])->name('index');
    Route::middleware('auth')->group(function () {


        // Route::get('usersWebsite/functionshowDetailsUserWebsite/{id}',[BackendUserwebsiteController::class,'functionshowDetailsUserWebsite'])->name('functionshowDetailsUserWebsite');
        Route::resource('announcements',BackendAnnouncementController::class);
        Route::resource('files',BackendFileController::class);
        Route::post('contacts/resolve',[BackendContactController::class,'resolve'])->name('contacts.resolve');
        Route::resource('contacts',BackendContactController::class);
        Route::resource('menus',BackendMenuController::class);
        Route::get('users/{user}/access',[BackendUserController::class,'access'])->name('users.access');
        Route::resource('users',BackendUserController::class);
        Route::resource('messages',BackendMessageController::class);
        Route::resource('roles',BackendRoleController::class);
        Route::get('user-roles/{user}',[BackendUserRoleController::class,'index'])->name('users.roles.index');
        Route::put('user-roles/{user}',[BackendUserRoleController::class,'update'])->name('users.roles.update');
        Route::resource('articles',BackendArticleController::class);
        Route::post('article-comments/change_status',[BackendArticleCommentController::class,'change_status'])->name('article-comments.change_status');
        Route::resource('article-comments',BackendArticleCommentController::class);
        Route::resource('pages',BackendPageController::class);
        Route::resource('usersWebsite',BackendUserwebsiteController::class);
        Route::resource('tags',BackendTagController::class);
        Route::resource('contact-replies',BackendContactReplyController::class);
        Route::post('faqs/order',[BackendFaqController::class,'order'])->name('faqs.order');
        Route::resource('faqs',BackendFaqController::class);
        Route::post('menu-links/get-type',[BackendMenuLinkController::class,'getType'])->name('menu-links.get-type');
        Route::post('menu-links/order',[BackendMenuLinkController::class,'order'])->name('menu-links.order');
        Route::resource('menu-links',BackendMenuLinkController::class);
        Route::resource('categories',BackendCategoryController::class);
        Route::resource('redirections',BackendRedirectionController::class);
        Route::get('traffics',[BackendTrafficsController::class,'index'])->name('traffics.index');
        Route::get('traffics/logs',[BackendTrafficsController::class,'logs'])->name('traffics.logs');
        Route::get('error-reports',[BackendTrafficsController::class,'error_reports'])->name('traffics.error-reports');
        Route::get('error-reports/{report}',[BackendTrafficsController::class,'error_report'])->name('traffics.error-report');

        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/',[BackendSettingController::class,'index'])->name('index');
            Route::put('/update',[BackendSettingController::class,'update'])->name('update');
        });
        Route::prefix('Pages-maker')->name('Pages-maker.')->group(function (){

            Route::get('/',[PageGeneratorController::class,'index'])->name('index');
            Route::get('/create',[PageGeneratorController::class,'create'])->name('create');
            Route::post('/createPage',[PageGeneratorController::class,'createPage'])->name('createPage');
            Route::get('/{table}',[PageGeneratorController::class,'show'])->name('show');
        });

    });

    Route::prefix('upload')->name('upload.')->group(function(){
        Route::post('/image',[BackendHelperController::class,'upload_image'])->name('image');
        Route::post('/file',[BackendHelperController::class,'upload_file'])->name('file');
        Route::post('/remove-file',[BackendHelperController::class,'remove_files'])->name('remove-file');
    });

    Route::prefix('plugins')->name('plugins.')->group(function(){
        Route::get('/',[BackendPluginController::class,'index'])->name('index');
        Route::get('/create',[BackendPluginController::class,'create'])->name('create');
        Route::post('/create',[BackendPluginController::class,'store'])->name('store');
        Route::post('/{plugin}/activate',[BackendPluginController::class,'activate'])->name('activate');
        Route::post('/{plugin}/deactivate',[BackendPluginController::class,'deactivate'])->name('deactivate');
        Route::post('/{plugin}/delete',[BackendPluginController::class,'delete'])->name('delete');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/',[BackendProfileController::class,'index'])->name('index');
        Route::get('/edit',[BackendProfileController::class,'edit'])->name('edit');
        Route::put('/update',[BackendProfileController::class,'update'])->name('update');
        Route::put('/update-password',[BackendProfileController::class,'update_password'])->name('update-password');
        Route::put('/update-email',[BackendProfileController::class,'update_email'])->name('update-email');
    });

    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/',[BackendNotificationsController::class,'index'])->name('index');
        Route::get('/ajax',[BackendNotificationsController::class,'ajax'])->name('ajax');
        Route::post('/see',[BackendNotificationsController::class,'see'])->name('see');
        Route::get('/create',[BackendNotificationsController::class,'create'])->name('create');
        Route::post('/create',[BackendNotificationsController::class,'store'])->name('store');
    });

// --------------------- about us -----------------------------
    Route::get('about/', [AboutUsController::class, 'index'])->name('aboutus.index');
    Route::get('about/create/', [AboutUsController::class, 'create'])->name('aboutus.create');
    Route::post('about/store/', [AboutUsController::class, 'store'])->name('aboutus.store');
    Route::get('about/edit/{id}', [AboutUsController::class, 'edit'])->name('aboutus.edit');
    Route::post('about/update/{id}', [AboutUsController::class, 'update'])->name('aboutus.update');
    Route::delete('about/destroy/{id}', [AboutUsController::class, 'destroy'])->name('aboutus.destroy');
// --------------------- servcies -----------------------------
    Route::get('services/', [ServicesController::class, 'index'])->name('services.index');
    Route::get('services/create/', [ServicesController::class, 'create'])->name('services.create');
    Route::post('services/store/', [ServicesController::class, 'store'])->name('services.store');
    Route::get('services/edit/{id}', [ServicesController::class, 'edit'])->name('services.edit');
    Route::post('services/update/{id}', [ServicesController::class, 'update'])->name('services.update');
    Route::delete('services/destroy/{id}', [ServicesController::class, 'destroy'])->name('services.destroy');
    // ----------------------- Our Clients --------------------------
    Route::get('clients/', [ClientsController::class, 'index'])->name('clients.index');
    Route::get('clients/create/', [ClientsController::class, 'create'])->name('clients.create');
    Route::post('clients/store/', [ClientsController::class, 'store'])->name('clients.store');
    Route::get('clients/edit/{id}', [ClientsController::class, 'edit'])->name('clients.edit');
    Route::post('clients/update/{id}', [ClientsController::class, 'update'])->name('clients.update');
    Route::delete('clients/destroy/{id}', [ClientsController::class, 'destroy'])->name('clients.destroy');
     // ----------------------- Our Cards --------------------------
     Route::get('cards/', [CardsController::class, 'index'])->name('cards.index');
     Route::get('cards/create/', [CardsController::class, 'create'])->name('cards.create');
     Route::post('cards/store/', [CardsController::class, 'store'])->name('cards.store');
     Route::get('cards/edit/{id}', [CardsController::class, 'edit'])->name('cards.edit');
     Route::post('cards/update/{id}', [CardsController::class, 'update'])->name('cards.update');
     Route::delete('cards/destroy/{id}', [CardsController::class, 'destroy'])->name('cards.destroy');
    // ----------------------- Slider --------------------------
    Route::get('contact_us/', [ContactUsController::class, 'index'])->name('contact_us.index');
    Route::get('contact_us/create/', [ContactUsController::class, 'create'])->name('contact_us.create');
    Route::post('contact_us/store/', [ContactUsController::class, 'store'])->name('contact_us.store');
    Route::get('contact_us/edit/{id}', [ContactUsController::class, 'edit'])->name('contact_us.edit');
    Route::post('contact_us/update/{id}', [ContactUsController::class, 'update'])->name('contact_us.update');
    Route::delete('contact_us/destroy/{id}', [ContactUsController::class, 'destroy'])->name('contact_us.destroy');
    // ----------------------- Contact Us --------------------------
    Route::get('slider/', [SliderController::class, 'index'])->name('slider.index');
    Route::get('slider/create/', [SliderController::class, 'create'])->name('slider.create');
    Route::post('slider/store/', [SliderController::class, 'store'])->name('slider.store');
    Route::get('slider/edit/{id}', [SliderController::class, 'edit'])->name('slider.edit');
    Route::post('slider/update/{id}', [SliderController::class, 'update'])->name('slider.update');
    Route::delete('slider/destroy/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');
    // ----------------------- Our Solution --------------------------
    Route::get('our_solution/', [OurSolutionController::class, 'index'])->name('our_solution.index');
    Route::get('our_solution/create/', [OurSolutionController::class, 'create'])->name('our_solution.create');
    Route::post('our_solution/store/', [OurSolutionController::class, 'store'])->name('our_solution.store');
    Route::get('our_solution/edit/{id}', [OurSolutionController::class, 'edit'])->name('our_solution.edit');
    Route::post('our_solution/update/{id}', [OurSolutionController::class, 'update'])->name('our_solution.update');
    Route::delete('our_solution/destroy/{id}', [OurSolutionController::class, 'destroy'])->name('our_solution.destroy');


});

Route::get('/login/google/redirect', [LoginController::class,'redirect_google']);
Route::get('/login/google/callback', [LoginController::class,'callback_google']);
Route::get('/login/facebook/redirect', [LoginController::class,'redirect_facebook']);
Route::get('/login/facebook/callback', [LoginController::class,'callback_facebook']);


Route::get('blocked',[BackendHelperController::class,'blocked_user'])->name('blocked');
Route::get('robots.txt',[BackendHelperController::class,'robots']);
Route::get('manifest.json',[BackendHelperController::class,'manifest'])->name('manifest');
Route::get('sitemap.xml',[BackendSiteMapController::class,'sitemap']);
Route::get('sitemaps/links',[BackendSiteMapController::class,'custom_links']);
Route::get('sitemaps/{name}/{page}/sitemap.xml',[BackendSiteMapController::class,'viewer']);


Route::view('contact','front.pages.contact')->name('contact');
Route::get('page/{page}',[FrontController::class,'page'])->name('page.show');
Route::get('tag/{tag}',[FrontController::class,'tag'])->name('tag.show');
Route::get('category/{category}',[FrontController::class,'category'])->name('category.show');
Route::get('article/{article}',[FrontController::class,'article'])->name('article.show');
Route::get('blog',[FrontController::class,'blog'])->name('blog');
Route::post('contact',[FrontController::class,'contact_post'])->name('contact-post');
Route::post('comment',[FrontController::class,'comment_post'])->name('comment-post');

############################################# front end API ######################################################

Route::get('/', [indexController::class, 'index'])->name('home');

// Route::middleware('api.security')->group(function () {

// });





############################################# front end ######################################################
// Route::get('/', [indexController::class,'index'])->name('home');
Route::get('/successfully', [indexController::class,'successfully'])->name('successfully');
Route::get('/تسجيل_عضوية', [indexController::class,'form_record'])->name('form_record');
Route::get('/changePage/{slug}', [indexController::class,'cahngePage'])->name('cahngePage');
Route::get('/goArticel/{slug}', [indexController::class,'goArticel'])->name('goArticel');
Route::get('/التواصل', [indexController::class,'contuct'])->name('contuct');




############################################# End front end ######################################################

Route::get('/test1/create', [App\Http\Controllers\Test1Controller::class, 'create'])->name('test1.create.web');
Route::get('/test1/edit', [App\Http\Controllers\Test1Controller::class, 'edit'])->name('test1.edit.web');
Route::get('/test1/index', [App\Http\Controllers\Test1Controller::class, 'index'])->name('test1.index.web');
Route::get('/test1/store', [App\Http\Controllers\Test1Controller::class, 'store'])->name('test1.store.web');
Route::get('/test1/update', [App\Http\Controllers\Test1Controller::class, 'update'])->name('test1.update.web');
Route::get('/test2/create', [App\Http\Controllers\controlPanal\Test2Controller::class, 'create'])->name('test2.create.web');
Route::get('/test2/edit', [App\Http\Controllers\controlPanal\Test2Controller::class, 'edit'])->name('test2.edit.web');
Route::get('/test2/index', [App\Http\Controllers\controlPanal\Test2Controller::class, 'index'])->name('test2.index.web');
Route::get('/test2/store', [App\Http\Controllers\controlPanal\Test2Controller::class, 'store'])->name('test2.store.web');
Route::get('/test2/update', [App\Http\Controllers\controlPanal\Test2Controller::class, 'update'])->name('test2.update.web');
Route::get('/test3/create', [App\Http\Controllers\controlPanal\Test3Controller::class, 'create'])->name('test3.create.web');
Route::get('/test3/edit', [App\Http\Controllers\controlPanal\Test3Controller::class, 'edit'])->name('test3.edit.web');
Route::get('/test3/index', [App\Http\Controllers\controlPanal\Test3Controller::class, 'index'])->name('test3.index.web');
Route::get('/test3/store', [App\Http\Controllers\controlPanal\Test3Controller::class, 'store'])->name('test3.store.web');
Route::get('/test3/update', [App\Http\Controllers\controlPanal\Test3Controller::class, 'update'])->name('test3.update.web');
Route::get('/test4/create', [App\Http\Controllers\controlPanal\Test4Controller::class, 'create'])->name('test4.create.web');
Route::get('/test4/edit', [App\Http\Controllers\controlPanal\Test4Controller::class, 'edit'])->name('test4.edit.web');
Route::get('/test4/index', [App\Http\Controllers\controlPanal\Test4Controller::class, 'index'])->name('test4.index.web');
Route::post('/test4/store', [App\Http\Controllers\controlPanal\Test4Controller::class, 'store'])->name('test4.store.web');
Route::post('/test4/update', [App\Http\Controllers\controlPanal\Test4Controller::class, 'update'])->name('test4.update.web');
Route::get('/exelexport/create', [App\Http\Controllers\controlPanal\ExelexportController::class, 'create'])->name('exelexport.create.web');
Route::get('/exelexport/index', [App\Http\Controllers\controlPanal\ExelexportController::class, 'index'])->name('exelexport.index.web');
Route::get('/exelexport/store', [App\Http\Controllers\controlPanal\ExelexportController::class, 'store'])->name('exelexport.store.web');
Route::get('/imagepro/create', [App\Http\Controllers\controlPanal\ImageproController::class, 'create'])->name('imagepro.create.web');
Route::get('/imagepro/edit', [App\Http\Controllers\controlPanal\ImageproController::class, 'edit'])->name('imagepro.edit.web');
Route::get('/imagepro/index', [App\Http\Controllers\controlPanal\ImageproController::class, 'index'])->name('imagepro.index.web');
Route::post('/imagepro/store', [App\Http\Controllers\controlPanal\ImageproController::class, 'store'])->name('imagepro.store.web');
Route::post('/imagepro/update', [App\Http\Controllers\controlPanal\ImageproController::class, 'update'])->name('imagepro.update.web');
Route::get('/imagetest/create', [App\Http\Controllers\controlPanal\ImagetestController::class, 'create'])->name('imagetest.create.web');
Route::get('/imagetest/edit', [App\Http\Controllers\controlPanal\ImagetestController::class, 'edit'])->name('imagetest.edit.web');
Route::get('/imagetest/index', [App\Http\Controllers\controlPanal\ImagetestController::class, 'index'])->name('imagetest.index.web');
Route::post('/imagetest/store', [App\Http\Controllers\controlPanal\ImagetestController::class, 'store'])->name('imagetest.store.web');
Route::post('/imagetest/update', [App\Http\Controllers\controlPanal\ImagetestController::class, 'update'])->name('imagetest.update.web');
Route::get('/imagetest1/create', [App\Http\Controllers\controlPanal\Imagetest1Controller::class, 'create'])->name('imagetest1.create.web');
Route::get('/imagetest1/edit', [App\Http\Controllers\controlPanal\Imagetest1Controller::class, 'edit'])->name('imagetest1.edit.web');
Route::get('/imagetest1/index', [App\Http\Controllers\controlPanal\Imagetest1Controller::class, 'index'])->name('imagetest1.index.web');
Route::post('/imagetest1/store', [App\Http\Controllers\controlPanal\Imagetest1Controller::class, 'store'])->name('imagetest1.store.web');
Route::post('/imagetest1/update', [App\Http\Controllers\controlPanal\Imagetest1Controller::class, 'update'])->name('imagetest1.update.web');
Route::get('/imagetest2/create', [App\Http\Controllers\controlPanal\Imagetest2Controller::class, 'create'])->name('imagetest2.create.web');
Route::get('/imagetest2/edit', [App\Http\Controllers\controlPanal\Imagetest2Controller::class, 'edit'])->name('imagetest2.edit.web');
Route::get('/imagetest2/index', [App\Http\Controllers\controlPanal\Imagetest2Controller::class, 'index'])->name('imagetest2.index.web');
Route::post('/imagetest2/store', [App\Http\Controllers\controlPanal\Imagetest2Controller::class, 'store'])->name('imagetest2.store.web');
Route::post('/imagetest2/update', [App\Http\Controllers\controlPanal\Imagetest2Controller::class, 'update'])->name('imagetest2.update.web');
Route::get('/imagetest3/create', [App\Http\Controllers\controlPanal\Imagetest3Controller::class, 'create'])->name('imagetest3.create.web');
Route::get('/imagetest3/edit/{id}', [App\Http\Controllers\controlPanal\Imagetest3Controller::class, 'edit'])->name('imagetest3.edit.web');
Route::get('/imagetest3/index', [App\Http\Controllers\controlPanal\Imagetest3Controller::class, 'index'])->name('imagetest3.index.web');
Route::get('/imagetest3/show', [App\Http\Controllers\controlPanal\Imagetest3Controller::class, 'show'])->name('imagetest3.show.web');
Route::post('/imagetest3/store', [App\Http\Controllers\controlPanal\Imagetest3Controller::class, 'store'])->name('imagetest3.store.web');
Route::post('/imagetest3/update', [App\Http\Controllers\controlPanal\Imagetest3Controller::class, 'update'])->name('imagetest3.update.web');
