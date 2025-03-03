<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Set the login view as index.
Route::get('/', function () {
    return view('waiter.login');
})->name('login');

// Get the login credentials from the view.
Route::post('/', [LoginController::class, 'loginPost'])->name('login.post');

// Get the logout function from Login Controller.
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Get the view from Product Controller.
Route::get('/order', [ProductController::class, 'index'])->name('order');

// Get the view from Menu Controller.
Route::get('/menu', [MenuController::class, 'mainMenu'])->name('menu');

// Get the view from Table Controller.
Route::get('/table', [OrdersController::class, 'index'])->name('table');

// Get the Table Number from the View.
Route::post('/table', [OrdersController::class, 'storeTable'])->name('storeTable');

// Get the view from Product Details Controller.
Route::get('/product-details/{id}', [ProductController::class, 'edit'])->name('product-details');

// Get the Dashboard page View from Admin Controller.
Route::get('/admin/', [AdminController::class, 'dashboard'])->name('admin-dashboard');

// Get the Dashboard Page Datas from Admin Controller.
Route::get('/admin/dashboard-data', [AdminController::class, 'getDashboardData'])->name('dashboard-data');

// Get the User Page view from Admin Controller.
Route::get('/admin/users', [AdminController::class, 'users'])->name('admin-users');

// Get the Create Users data from the View.
Route::post('/admin/users', [AdminController::class, 'addUserPost'])->name('addUser.post');

// Get the Edit Users Data from the View.
Route::put('/admin/users', [AdminController::class, 'editUserPost'])->name('editUser.post');

// Get the filtered users from the Controller.
Route::get('/filteredUser', [AdminController::class, 'getFilteredUsers'])->name('filterUser.get');

// Get the Product Page view from Admin Controller.
Route::get('/admin/products', [AdminController::class, 'products'])->name('admin-products');

// Get the Create Product Data from the View.
Route::post('/admin/products', [AdminController::class, 'addProductPost'])->name('addProduct.post');

// Get the Edit Product Data from the View.
Route::put('/admin/products', [AdminController::class, 'editProductPost'])->name('editProduct.post');

// Get the filtered products from the Controller.
Route::get('/filteredProducts', [AdminController::class, 'getFilteredProducts'])->name('filterProducts.get');

// Get the Inventory Page view from Admin Controller.
Route::get('/admin/inventory', [AdminController::class, 'inventory'])->name('admin-inventory');

// Get the Create Inventory Data from the View.
Route::post('admin/inventory', [AdminController::class, 'addInventoryPost'])->name('addInventory.post');

// Get the Edit Inventory Data from the View.
Route::put('admin/inventory', [AdminController::class, 'editInventoryPost'])->name('editInventory.post');

// Get the filtered Inventory from the Controller.
Route::get('/filteredInventories', [AdminController::class, 'getFilteredInventories'])->name('filterInventories.get');

// Get the Voucher Page view from Admin Controller.
Route::get('admin/vouchers', [AdminController::class, 'vouchers'])->name('admin-vouchers');

// Get the Create Vouchers Data from the View.
Route::post('admin/vouchers', [AdminController::class, 'addVoucherPost'])->name('addVoucher.post');

// Get the Edit Voucher Data from the View.
Route::put('admin/vouchers', [AdminController::class, 'editVoucherPost'])->name('editVoucher.post');

// Get the filtered Vouchers from the Controller.
Route::get('/filteredVouchers', [AdminController::class, 'getFilteredVouchers'])->name('filterVouchers.get');

// Get the Payment view from the Controller.
Route::get('admin/payments', [AdminController::class, 'payments'])->name('admin-payments');

// Get the filtered payments from the Controller.
Route::get('/filteredPayments', [AdminController::class, 'getFilteredPayments'])->name('filterPayments.get');

// Get the Add To Cart Datas from the View.
Route::post('order', [OrdersController::class, 'addToCartPost'])->name('addToCart.post');

// Get the Summary Page view from Order Controller.
Route::get('/summary', [OrdersController::class, 'orderSummary'])->name('orderSummary');

// Get the Order Items Datas from the View.
Route::post('/summary', [OrdersController::class, 'addOrderPost'])->name('addOrder.post');

Route::post('/apply-voucher', [PaymentController::class, 'applyVoucher'])->name('applyVoucher');

Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');

// Get the cart item from the View.
Route::post('/summary/remove', [OrdersController::class, 'removeFromCart'])->name('cart.remove');

// Get the Track Order View from Order Controller.
Route::get('/track-order', [OrdersController::class, 'trackOrder'])->name('trackOrder');

// Get the Order History View from the Order Controller.
Route::get('/order-history', [OrdersController::class, 'orderHistory'])->name('orderHistory');

// Get the OrderID from the View.
Route::put('/orders/update-status', [OrdersController::class, 'updateOrderStatusCompleted'])->name('orders.update-status');

Route::get('/cashier/order', [ProductController::class, 'index'])->name('cashier.order');

Route::post('/cashier/order/add-to-order', [OrdersController::class, 'addOrderPost'])->name('cashier.addOrder.post');

Route::post('/cashier/cart/remove', [OrdersController::class, 'removeFromCart'])->name('cashierCart.remove');

Route::get('/cashier/order/edit/{id}', [ProductController::class, 'getProductDetails'])->name('cashier.order.edit');

Route::get('/cashier/table', [OrdersController::class, 'cashierIndex'])->name('cashier.table');

Route::get('/track-inventory', [InventoryController::class, 'trackInventory'])->name('cashier.inventory');

Route::post('cashier/inventory', [InventoryController::class, 'addInventoryPost'])->name('cashierAddInventory.post');

Route::put('cashier/inventory', [InventoryController::class, 'editInventoryPost'])->name('cashierEditInventory.post');

Route::post('cashier/inventory', [InventoryController::class, 'addInventoryPost'])->name('cashierAddInventory.post');

Route::put('cashier/inventory', [InventoryController::class, 'editInventoryPost'])->name('cashierEditInventory.post');

Route::get('/paymentSuccess', [PaymentController::class, 'index'])->name('order.success');

Route::get('/low-stock-inventories', [AdminController::class, 'getLowStockInventories']);

Route::post('/cashier/order/add-to-cart', [OrdersController::class, 'addToCartPost'])->name('cashier.addToCart.post');

Route::get('/kitchen/order-items', [OrdersController::class, 'kitchenIndex'])->name('kitchen.index');

Route::get('/kitchen/order-items-data', [OrdersController::class, 'trackOrderItems'])->name('kitchen.order-items');
