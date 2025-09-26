<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');
Route::post('/logout', Logout::class)->name('logout');

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
