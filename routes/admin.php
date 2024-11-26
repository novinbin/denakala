<?php

use App\Http\Controllers\Auth_Admin\AdminLoginController;
use App\Http\Controllers\Auth_Admin\AdminProfileController;
use App\Http\Controllers\Auth_Admin\AdminValidateController;
use App\Http\Controllers\Dash\Address\AdminCityController;
use App\Http\Controllers\Dash\Address\AdminProvinceController;
use App\Http\Controllers\Dash\AdminController;
use App\Http\Controllers\Dash\AdminPermAssignController;
use App\Http\Controllers\Dash\AdminRoleAssignController;
use App\Http\Controllers\Dash\Discount\CommonDiscountController;
use App\Http\Controllers\Dash\NotificationController;
use App\Http\Controllers\Dash\Order\AdminOrderController;
use App\Http\Controllers\Dash\Payment\PaymentController;
use App\Http\Controllers\Dash\Advertisement\ProductController;
use App\Http\Controllers\Dash\Setting\SettingController;
use App\Http\Controllers\Dash\Ticket\AdminAdminTicketController;
use App\Http\Controllers\Dash\Ticket\AdminCategoryTicketController;
use App\Http\Controllers\Dash\Ticket\AdminPriorityTicketController;
use App\Http\Controllers\Dash\Ticket\AdminTicketController;
use App\Livewire\Admin\Category\AdminSubCategory;
use App\Livewire\Admin\Packages\AdminSubscription;
use App\Livewire\Admin\Packages\AdminSubscriptionsDuration;
use App\Livewire\Admin\Setting\AdminSetting;
use App\Livewire\Admin\Category\AdminCategoryCreate;
use App\Livewire\Admin\Category\AdminCategoryEdit;
use App\Livewire\Admin\Advertisement\Advertisements;
use App\Livewire\Admin\Orders\AdminAllOrders;
use App\Livewire\Admin\Permission\AdminPerms;
use App\Livewire\Admin\Permission\AdminRoles;
use App\Livewire\Admin\Permission\ListUsersForPerm;
use App\Livewire\Admin\Permission\ListUsersForRole;
use App\Livewire\Admin\Users\AdminAdmins;
use App\Livewire\Admin\Users\AdminUsers;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin'], function () {

    Route::get('login/form', [AdminLoginController::class, 'loginForm'])->name('admin.login.form');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login');

    Route::get('/validate', [AdminValidateController::class, 'validateEmailForm'])->name('admin.validate.email.form');
    Route::post('/validate', [AdminValidateController::class, 'validateEmail'])->name('admin.validate.email');


});


// 'verify_admin'
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [AdminProfileController::class, 'profile'])->name('profile');
    Route::post('/update/profile', [AdminProfileController::class, 'update'])->name('update.profile');

    Route::get('/edit/mobile', [AdminProfileController::class, 'editMobile'])->name('edit.mobile');
    Route::post('/update/mobile', [AdminProfileController::class, 'updateMobile'])->name('update.mobile');

    Route::get('/logout', [AdminLoginController::class, 'logOut'])->name('logout');

});

// 'verify_admin',
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {

    Route::get('/users/index', AdminUsers::class)->name('users');
    Route::get('/admins/index', AdminAdmins::class)->name('admins');

});

// 'verify_admin',
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {

    Route::get('/perms/index', AdminPerms::class)->name('perms');
    Route::get('/roles/index', AdminRoles::class)->name('roles');

});
// 'verify_admin',
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {

    Route::get('/roles/list/users', ListUsersForRole::class)->name('role.list.users');
    Route::get('/roles/assign/form', [AdminRoleAssignController::class, 'create'])->name('roles.assign.form');
    Route::post('/roles/assign', [AdminRoleAssignController::class, 'store'])->name('roles.assign');

});

// 'verify_admin',
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {

    Route::get('/perms/list/users', ListUsersForPerm::class)->name('perm.list.users');
    Route::get('/perms/assign/form', [AdminPermAssignController::class, 'create'])->name('perms.assign.form');
    Route::post('/perms/assign', [AdminPermAssignController::class, 'store'])->name('perms.assign');

});

// 'verify_admin',
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {

    //
    Route::get('/category/create', AdminCategoryCreate::class)->name('category.create');
    Route::get('/category/edit/{id}', AdminCategoryEdit::class)->name('category.edit');
    //
    Route::get('/sub-category/create/{sub_cat_id}', AdminSubCategory::class)->name('sub.category.create');

});

// 'verify_admin',
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {

    //
    Route::get('/packages/create', AdminSubscription::class)->name('packages.create');
    Route::get('/packages/items/{id}', AdminSubscriptionsDuration::class)->name('packages.items');


});


// payments routes
// 'verify_admin',
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {

    Route::get('/payments-all/index', [PaymentController::class, 'index'])->name('payments.all.index');
    ////
    Route::get('/payments-offline/index', [PaymentController::class, 'offline'])->name('payments.offline.index');
    Route::get('/payments-online/index', [PaymentController::class, 'online'])->name('payments.online.index');
    ////
    Route::get('/payment-canceled/{payment}', [PaymentController::class, 'canceled'])->name('payment.canceled');
    Route::get('/payment-returned/{payment}', [PaymentController::class, 'returned'])->name('payment.returned');
    ////
    Route::get('/payment-show/{payment}', [PaymentController::class, 'show'])->name('payment.show');

});

// 'verify_admin',
// order routes
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {

    Route::get('/all-orders', AdminAllOrders::class)->name('orders.index');

    Route::get('/orders-new', [AdminOrderController::class, 'newOrders'])->name('orders.new');

    Route::get('/orders-sending', [AdminOrderController::class, 'sending'])->name('orders.sending');

    Route::get('/orders-unpaid', [AdminOrderController::class, 'unpaid'])->name('orders.unpaid');

    Route::get('/orders-paid', [AdminOrderController::class, 'paid'])->name('orders.paid');

    Route::get('/orders-canceled', [AdminOrderController::class, 'canceled'])->name('orders.canceled');

    Route::get('/orders-returned', [AdminOrderController::class, 'returned'])->name('orders.returned');

    Route::get('/show-order/{order}', [AdminOrderController::class, 'show'])->name('order.show');

    Route::get('/order-details/{order}', [AdminOrderController::class, 'details'])->name('order.details');

});

// 'verify_admin',
// 'auth:admin'
// common discount routes
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {

    Route::get('/common-discount/index', [CommonDiscountController::class, 'index'])->name('common.discount.index');
    ////
    Route::get('/common-discount/create', [CommonDiscountController::class, 'create'])->name('common.discount.create');
    Route::post('/common-discount/store', [CommonDiscountController::class, 'store'])->name('common.discount.store');
    ////
    Route::get('/common-discount/edit/{discount}', [CommonDiscountController::class, 'edit'])->name('common.discount.edit');
    Route::post('/common-discount/update', [CommonDiscountController::class, 'update'])->name('common.discount.update');

});


// province routes
// 'verify_admin',
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {

    Route::get('/province/index', [AdminProvinceController::class, 'index'])->name('province.index');
    Route::post('/province/store', [AdminProvinceController::class, 'store'])->name('province.store');
    ////
    Route::get('/province/edit/{province}', [AdminProvinceController::class, 'edit'])->name('province.edit');
    Route::post('/province/update', [AdminProvinceController::class, 'update'])->name('province.update');
    ////
    Route::get('/province/delete/{province}', [AdminProvinceController::class, 'delete'])->name('province.delete');

});

// ,'verify_admin'
// crud product routes
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {

    Route::get('/adv/index', Advertisements::class)->name('adv.index');

    // new product
    Route::get('/adv/create', [ProductController::class, 'create'])->name('adv.create');
    Route::post('/adv/store', [ProductController::class, 'store'])->name('adv.store');
    Route::post('/adv-save-images',[ProductController::class,'storeAdvImages'])->name('adv-save-images');
    // edit product
    Route::get('/adv/edit/{adv}', [ProductController::class, 'edit'])->name('adv.edit');
    Route::post('/adv/update', [ProductController::class, 'update'])->name('adv.update');


});

// 'verify_admin',
// ticket routes
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {

    Route::get('/category-tickets', [AdminCategoryTicketController::class, 'categoryTickets'])->name('category.tickets');
    Route::get('/category-ticket/create', [AdminCategoryTicketController::class, 'create'])->name('category.ticket.create');
    Route::post('/category-ticket/store', [AdminCategoryTicketController::class, 'store'])->name('category.ticket.store');
    Route::get('/category-ticket/edit/{ticketCategory}', [AdminCategoryTicketController::class, 'edit'])->name('category.ticket.edit');
    Route::post('/category-ticket/update', [AdminCategoryTicketController::class, 'update'])->name('category.ticket.update');
    ////
    Route::get('/priority-tickets', [AdminPriorityTicketController::class, 'priorityTickets'])->name('priority.tickets');
    Route::get('/priority-ticket/create', [AdminPriorityTicketController::class, 'create'])->name('priority.ticket.create');
    Route::post('/priority-ticket/store', [AdminPriorityTicketController::class, 'store'])->name('priority.ticket.store');
    Route::get('/priority-ticket/edit/{ticketPriority}', [AdminPriorityTicketController::class, 'edit'])->name('priority.ticket.edit');
    Route::post('/priority-ticket/update', [AdminPriorityTicketController::class, 'update'])->name('priority.ticket.update');

});

// 'verify_admin',
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {

    Route::get('/all-tickets', [AdminTicketController::class, 'allTickets'])->name('all.tickets');
    Route::get('/new-tickets', [AdminTicketController::class, 'newTickets'])->name('new.tickets');
    Route::get('/open-tickets', [AdminTicketController::class, 'openTickets'])->name('open.tickets');
    Route::get('/close-tickets', [AdminTicketController::class, 'closeTickets'])->name('close.tickets');
    Route::get('/show-ticket/{ticket}', [AdminTicketController::class, 'showTicket'])->name('show.ticket');
    Route::post('/answer-ticket/{ticket}', [AdminTicketController::class, 'answer'])->name('answer.ticket');
    Route::get('/change-status/ticket/{ticket}', [AdminTicketController::class, 'changeStatus'])->name('change.status.ticket');

});

// 'verify_admin',
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {

    Route::get('/admin-tickets/index', [AdminAdminTicketController::class, 'index'])->name('admin.tickets.index');
    Route::get('/set/admin-ticket/{admin}', [AdminAdminTicketController::class, 'setAdmin'])->name('set.admin.ticket');

});

// 'verify_admin',
// cities routes
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {


    Route::get('/get/cities', [AdminCityController::class, 'getCities'])->name('get.cities');
    Route::get('/city/create', [AdminCityController::class, 'create'])->name('city.create');
    Route::post('/city/store', [AdminCityController::class, 'store'])->name('city.store');
    ////
     Route::get('/city/edit/{city}', [AdminCityController::class, 'edit'])->name('city.edit');
     Route::post('/city/update', [AdminCityController::class, 'update'])->name('city.update');
    /////
     Route::post('/city/delete/{city}', [AdminCityController::class, 'delete'])->name('city.delete');

});

// setting routes
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {

    Route::get('/setting/index', AdminSetting::class)->name('setting.index');
    Route::get('/setting/edit/{setting}', [SettingController::class, 'edit'])->name('setting.edit');
    Route::post('/setting/update', [SettingController::class, 'update'])->name('setting.update');

});

// notification routes
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:admin|super_admin'])->group(function () {

    Route::get('/notification/read-all', [NotificationController::class, 'readNotifications'])->name('notification.read.all');

});
