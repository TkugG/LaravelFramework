<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

// หน้าแรก และ หน้าฟอร์มจองคิวซ่อม/ล้างแอร์
Route::get('/', [BookingController::class, 'create']);
Route::get('/booking', [BookingController::class, 'create']);
Route::post('/booking', [BookingController::class, 'store']);

// หน้าค้นหาและติดตามสถานะคิวงานด้วยเบอร์โทรศัพท์
Route::get('/track', [BookingController::class, 'track']);

// ฝั่งช่าง/ร้าน (Admin Dashboard & เปลี่ยนสถานะงาน)
Route::get('/admin', [BookingController::class, 'admin']);
Route::post('/admin/bookings/{id}/status', [BookingController::class, 'updateStatus']);
