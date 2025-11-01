<?php


use App\Livewire\Actions\Logout;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Register;

use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyResetCode;
use App\Livewire\Dashboard\Home;
use App\Livewire\Dashboard\User\Settings\UserSettings;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;




Route::view('/', 'welcome')->name('welcome');
Route::post('/logout', Logout::class)->name('logout');

Route::middleware('guest')->group(function () {
//    Volt::route('register', 'pages.auth.register')
//        ->name('register');

    Route::get('/register', Register::class)->name('register');
    Route::middleware('EnsureVerifyCodeSession')->get('/verify-code', \App\Livewire\Auth\VerifyCode::class)->name('verify.code');

//
    Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');

// فراموشی رمز عبور (وارد کردن شماره موبایل)
    Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');

// تأیید کد ارسال‌شده
    Route::get('/verify-reset-code', VerifyResetCode::class)->name('verify-reset-code');

// وارد کردن رمز جدید
    Route::get('/reset-password', ResetPassword::class)->name('reset-password');
});


Route::view('/offline', 'offline');


//Route::view('dashboard', 'dashboard')
//    ->middleware(['auth', 'verified'])
//    ->name('dashboard');
//
//Route::view('profile', 'profile')
//    ->middleware(['auth'])
//    ->name('profile');

require __DIR__.'/auth.php';



//Route::middleware(['auth',CheckModelOwnership::class])->group(function () {
//    Route::get('/dashboard', Home::class)->name('dashboard');
//    Route::post('/logout', Logout::class)->name('logout');
//
//    //bank manager
//    Route::get('/dashboard/bank-manager', BankManager::class)->name('dashboard.bank-manager');
//    Route::get('/dashboard/add-bank', AddBank::class)->name('dashboard.add-bank');
//    Route::get('/dashboard/edit-bank/{id}', EditBank::class)->name('dashboard.edit-bank');
//    Route::get('/dashboard/show-transaction-bank/{id}', ShowTransactionBank::class)->name('dashboard.show-transaction-bank');


    //update info
//    Route::get('/dashboard/show-users', \App\Livewire\Dashboard\Admin\ShowAllUser::class)->name('dashboard.show-users')->middleware(AdminOnly::class);

//});



//    ==================>Admin dashboard <===================
Route::middleware(['auth', 'AdminOnly'])->group(function () {

    Route::get('/dashboard/user-manager', \App\Livewire\Dashboard\Admin\User::class)->name('dashboard.user-manager');
    Route::get('/dashboard/edit-user/{id}', \App\Livewire\Dashboard\Admin\EditUser::class)->name('dashboard.edit-user');
    Route::get('/dashboard/sliders', \App\Livewire\Dashboard\Admin\Slider\Sliders::class)->name('dashboard.sliders');
    Route::get('/dashboard/pkg-manager', \App\Livewire\Dashboard\Admin\Pkg\PkgManager::class)->name('dashboard.pkg-manager');
    Route::get('/dashboard/shop-product', \App\Livewire\Dashboard\Admin\Shop\ShopProducts::class)->name('dashboard.shop-product');
    Route::get('/dashboard/support', \App\Livewire\Dashboard\Admin\Support\SupportManager::class)->name('dashboard.support');
    Route::get('/dashboard/user-point', \App\Livewire\Dashboard\Admin\UserPoints\UserPointsManager::class)->name('dashboard.user-point');
    Route::get('/dashboard/pkg-request', \App\Livewire\Dashboard\Admin\PackageRequests\PackageRequestManager::class)->name('dashboard.pkg-request');
    Route::get('/dashboard/evacuation-request', \App\Livewire\Dashboard\Admin\Evacuation\EvacuationManager::class)->name('dashboard.evacuation-request');
    Route::get('/dashboard/referral',\App\Livewire\Dashboard\Admin\Referral\AdminReferral ::class)->name('dashboard.referral');
    Route::get('/dashboard/shop-order',\App\Livewire\Dashboard\Admin\Shop\AdminShopOrders ::class)->name('dashboard.shop-order');
    });

    //Route::middleware(['auth', 'AdminOnly'])->group(function () {
//});


//      ======================>user <===========================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Home::class)->name('admin.dashboard');
    Route::get('/dashboard/settings', UserSettings::class)->name('user.settings');
Route::get('/dashboard/user/pkg-request', \App\Livewire\Dashboard\User\PackageRequest\UserPackageRequest::class)->name('dashboard.user.pkg-request');
Route::get('/dashboard/user/clearance-request', \App\Livewire\Dashboard\User\RequestClearance\UserRequestClearance::class)->name('dashboard.user.clearance-request');
Route::get('/dashboard/user/referral',\App\Livewire\Dashboard\User\Referral\UserReferral ::class)->name('dashboard.user.referral');
Route::get('/dashboard/user/user-shop', \App\Livewire\Dashboard\User\Shop\UserShop ::class)->name('dashboard.user.user-shop');
});
