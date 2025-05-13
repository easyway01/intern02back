<?php

use Illuminate\Support\Facades\Route;  
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodoController;

// ✅ 首页重定向到任务列表（或 calendar 页面）
Route::get('/', function () {
    return redirect()->route('calendar'); // 确保已定义 route('calendar')
});

// ✅ Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ✅ Calendar 路由（保留这一个即可）
Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
Route::get('/todos', [CalendarController::class, 'getEvents']);
Route::post('/todos', [CalendarController::class, 'store']);
Route::put('/todos/{id}', [CalendarController::class, 'update']);
Route::delete('/todos/{id}', [CalendarController::class, 'destroy']);

// ✅ Tasks 路由（仅限基本 CRUD）
Route::resource('tasks', TaskController::class)->only(['index', 'create', 'store', 'destroy']);
Route::put('/tasks/{id}', [TaskController::class, 'update']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);

// ✅ 用户认证相关的中间件群组
Route::middleware(['auth'])->group(function () {

    // 个人资料
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 购物车
    Route::post('/add-cart', [CartController::class, 'addCart'])->name('addCart');
    Route::get('/my-cart', [CartController::class, 'view'])->name('myCart');

    // 产品管理
    Route::get('/addProduct', [ProductController::class, 'create'])->name('addProduct');
    Route::post('/addProduct/store', [ProductController::class, 'store'])->name('addProduct.store');
    Route::get('/showProduct', [ProductController::class, 'index'])->name('showProduct');
    Route::get('/editProduct/{id}', [ProductController::class, 'edit'])->name('editProduct');
    Route::post('/updateProduct/{id}', [ProductController::class, 'update'])->name('updateProduct');
    Route::get('/deleteProduct/{id}', [ProductController::class, 'delete'])->name('deleteProduct');

    // 搜索功能
    Route::get('/search', [ProductController::class, 'search'])->name('searchProduct');
    Route::get('/products/autocomplete', [ProductController::class, 'autocomplete'])->name('products.autocomplete');
});

// ✅ 管理员专属页面
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});

// ✅ 商品展示
Route::get('/products', [ProductController::class, 'index'])->name('productList');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('productDetail');

// ✅ 加入购物车（不需要登录）
Route::post('/add-to-cart', [CartController::class, 'add'])->name('addCart');

// ✅ Laravel 自带 auth 路由
require __DIR__ . '/auth.php';
