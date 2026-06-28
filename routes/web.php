<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 🎯 จุดที่ 1: แก้ไขตรงนี้! เปลี่ยนจาก 'welcome' ให้ดึงหน้าแรกไฟล์ลูก 'home' ของเรามาโชว์
Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/test-power', function () {
    return 'ขุมพลังดาร์ก 12 ตื่นจากการหลับใหลแล้ว!';
});

// 🎯 จุดที่ 2: เพิ่มเส้นทางใหม่ 2 สายนี้เข้าไปต่อท้ายล่างสุดได้เลยเดี๋ยวนี้!
Route::get('/about', function () {
    // สร้างอาเรย์เก็บรายชื่อสมุนเฝ้าประตูเมือง
    $guards = ['อสูรมังกรดำเดธวิง', 'แม่มดเงาแห่งอันเดอร์ซิตี้', 'จอมทำลายล้างบาฮามุท'];

    // ส่งตัวแปร $guards ข้ามมิติไปที่หน้า View ชื่อ about
    return view('about', compact('guards'));
});

Route::get('/contact', function () {
    return view('contact');
});


Route::get('/hello', function () {
    return view('hello');
});

// 1. ซ้อมรับค่า ID ของบทความ (มาตรฐานตามสไลด์หน้า 24)
Route::get('/blog/{id}', function ($id) {
    return "this is blog page: " . $id;
});

// 2. ซ้อมรับค่าพารามิเตอร์แบบ 3 ตัวแปรพร้อมกัน (มาตรฐานตามสไลด์หน้า 29)
Route::get('/product/{a}/{b}/{c}', function ($a, $b, $c) {
    return "result: " . $a . " " . $b . " " . $c;
});

// 3. ซ้อมรับค่าแบบมีค่าเริ่มต้น (Optional Parameter - มาตรฐานตามสไลด์หน้า 32)
Route::get('/category/{name?}', function ($name = 'movie') {
    return "category: " . $name;
});

// 📊 สลักเส้นทางระบบคลังภาพ Quiz 1+2 (เรียกไฟล์จากในโฟลเดอร์ test)
Route::get('/gallery', function () {
    return view('test.index'); // จุดทศนิยม (.) หมายถึงการเข้าไปในโฟลเดอร์ test/
});

Route::get('/gallery/ant', function () {
    return view('test.ant');
});

Route::get('/gallery/bird', function () {
    return view('test.bird');
});

Route::get('/gallery/cat', function () {
    return view('test.cat');
});