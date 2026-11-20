<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffAuthController;
use App\Http\Controllers\StaffController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ---------------- Staff only ----------------
Route::middleware("auth:staff")->group(function () {
    Route::get('/staff-me',      [StaffAuthController::class, 'me']);
    Route::post('/staff-logout', [StaffAuthController::class, 'logout']);

    Route::get('/staff',         [StaffController::class, 'index']);
    Route::post('/staff',        [StaffController::class, 'store']);
    Route::get('/staff/{id}',    [StaffController::class, 'show']);
    Route::put('/staff/{id}',    [StaffController::class, 'update']);
    Route::delete('/staff/{id}', [StaffController::class, 'destroy']);

    Route::post('/category',                [CategoryController::class, 'store']);
    Route::put('/category/{category}',      [CategoryController::class, 'update']);
    Route::delete('/category/{category}',   [CategoryController::class, 'destroy']);

    Route::post('/book',            [BookController::class, 'store']);
    Route::put('/book/{book}',      [BookController::class, 'update']);
    Route::delete('/book/{book}',   [BookController::class, 'destroy']);

    // Borrowings (staff)
    Route::put("/borrowings/return", [BorrowingsController::class, "markAsReturned"]);
    Route::get("/borrowings/all",    [BorrowingsController::class, "all"]);
    Route::get("/borrowings/overdue", [BorrowingsController::class, "overdue"]);

    // Customers (staff)
    Route::get('/customer',              [CustomerController::class, 'index']);
    Route::get('/customer/{customer}',   [CustomerController::class, 'show']);
});

// ---------------- Customer only ----------------
Route::middleware("auth:customer")->group(function () {
    Route::get('/customer-me',        [CustomerAuthController::class, 'me']);
    Route::post('/customer-logout',   [CustomerAuthController::class, 'logout']);

    Route::post("/borrowings",          [BorrowingsController::class, "borrow"]);
    Route::get("/borrowings",           [BorrowingsController::class, "borrowings"]);
    Route::delete("/borrowings/{id}",   [BorrowingsController::class, "delete"]);
});

// ---------------- Any valid token (read only) ----------------
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/category',            [CategoryController::class, 'index']);
    Route::get('/category/{category}', [CategoryController::class, 'show']);
    Route::get("/book",                [BookController::class, "index"]);
    Route::get("/book/{book}",         [BookController::class, "show"]);
});

// ---------------- Public ----------------
Route::post('/staff/login',    [StaffAuthController::class, 'login']);
Route::post('/customer/login', [CustomerAuthController::class, 'login']);
Route::post('/customer',       [CustomerController::class, 'store']);
