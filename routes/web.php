<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

// ✅ 首页重定向到 dashboard
Route::get('/', function () {
    return view('dashboard');
});

// ✅ Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ✅ 登录 & 注册
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// ✅ 用户相关功能（需登录）
Route::middleware(['auth'])->group(function () {
    // ✅ Calendar 页面
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

    // ✅ Calendar 数据接口 (Todos)
    Route::get('/events', [CalendarController::class, 'getEvents']);

    Route::get('/todos', [CalendarController::class, 'getEvents']);
    Route::post('/todos', [CalendarController::class, 'store']);
    Route::put('/todos/{id}', [CalendarController::class, 'update']);
    Route::delete('/todos/{id}', [CalendarController::class, 'destroy'])->name('todos.destroy');
    Route::put('/todos/{id}/done', [TodoController::class, 'markAsDone']);
    
    // ✅ Task List 页面
    Route::get('/task-list', function () {
        return view('task-list');
    });

    Route::get('/task-list', [TaskController::class, 'taskListView'])->name('task.list');


    // ✅ Task Controller（管理完整任务资源）
    Route::resource('task', TaskController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::put('/task/{id}', [TaskController::class, 'update']);

    

    // ✅ 用户资料编辑
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ 产品 & 购物车功能
    Route::post('/add-cart', [CartController::class, 'addCart'])->name('addCart');
    Route::get('/my-cart', [CartController::class, 'view'])->name('myCart');

    Route::get('/addProduct', [ProductController::class, 'create'])->name('addProduct');
    Route::post('/addProduct/store', [ProductController::class, 'store'])->name('addProduct.store');
    Route::get('/showProduct', [ProductController::class, 'index'])->name('showProduct');
    Route::get('/editProduct/{id}', [ProductController::class, 'edit'])->name('editProduct');
    Route::post('/updateProduct/{id}', [ProductController::class, 'update'])->name('updateProduct');
    Route::get('/deleteProduct/{id}', [ProductController::class, 'delete'])->name('deleteProduct');

    Route::get('/search', [ProductController::class, 'search'])->name('searchProduct');
    Route::get('/products/autocomplete', [ProductController::class, 'autocomplete'])->name('products.autocomplete');
});

// ✅ 商品展示（无需登录）
Route::get('/products', [ProductController::class, 'index'])->name('productList');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('productDetail');
Route::post('/add-to-cart', [CartController::class, 'add'])->name('addCart');

// ✅ 管理员后台页面（admin 中间件保护）
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});

// ✅ Laravel 默认 Auth 支持
require __DIR__ . '/auth.php';
