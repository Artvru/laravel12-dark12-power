<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

 use App\Models\Product;
 use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



// จุดที่ 1: แก้ไขตรงนี้! เปลี่ยนจาก 'welcome' ให้ดึงหน้าแรกไฟล์ลูก 'home' ของเรามาโชว์
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

//  จุดที่ 2: เพิ่มเส้นทางใหม่ 2 สายนี้เข้าไปต่อท้ายล่างสุดได้เลยเดี๋ยวนี้!
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

// สลักเส้นทางระบบคลังภาพ Quiz 1+2 (เรียกไฟล์จากในโฟลเดอร์ test)
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

// --- Section 2: Bootstrap Pages ---
Route::get('/student', function () {
    return view('student');
});

Route::get('/teacher', function () {
    return view('teacher');
});

Route::get("/theme" , function (){
	return view("theme");
});

// --- Section 7: Active Bootstrap Theme ---
Route::get('/active/index', function () {
    return view('active.index');
})->name('index');

// --- Phase 3: Active Bootstrap Pages ---
Route::get('/active/about', function () {
    return view('active/about');
})->name('about');

Route::get('/active/services', function () {
    return view('active/services');
})->name('services');

Route::get('/active/portfolio', function () {
    return view('active/portfolio');
})->name('portfolio');

Route::get('/active/team', function () {
    return view('active/team');
})->name('team');

Route::get('/active/blog', function () {
    return view('active/blog');
})->name('blog');

Route::get('/active/contact', function () {
    return view('active/contact');
})->name('contact');

//งานใหม่จากตรงนี้ route มันจะแปลกๆ หน่อย นั่นแหละงานใหม่
Route::get('/test',function(){
    return view('test');
})->name('test');


Route::get('/coronavirus',function(){
    $reports = [
        (object) ["country"=>"China" , "date"=>"2020-04-19" , "total"=>"2765", "active"=>"790"  , "death"=>"47", "recovered"=>"1928"],
        (object) ["country"=>"Thailand" , "date"=>"2020-04-18" , "total"=>"2733", "active"=>"899"  , "death"=>"47", "recovered"=>"1787"],
        (object) ["country"=>"Thailand" , "date"=>"2020-04-17" , "total"=>"2700", "active"=>"964"  , "death"=>"47", "recovered"=>"1689"],
        (object) ["country"=>"Thailand" , "date"=>"2020-04-16" , "total"=>"2672", "active"=>"1033" , "death"=>"46", "recovered"=>"1593"],
        (object) ["country"=>"Thailand" , "date"=>"2020-04-15" , "total"=>"2643", "active"=>"1103" , "death"=>"43", "recovered"=>"1497"],
    ];
    return view("coronavirus", compact("reports") );
})->name('coronavirus');

//ตรงนี้มันเป็นอีก route กันงง
Route::get('/active/teacher', function () {
    $teachers = json_decode(file_get_contents('https://raw.githubusercontent.com/arc6828/laravel8/main/public/json/teachers.json'));
    return view("active.teacher", compact("teachers"));
})->name('active.teacher');


Route::get('/category/sport', [CategoryController::class, "sport"]);
Route::get('/category/politic', [CategoryController::class, "politic"]);
Route::get('/category/entertain', [CategoryController::class, "entertain"]);
Route::get('/category/auto', [CategoryController::class, "auto"]);


//----------------------------------------------



Route::get('query/sql', function () {
    $products = DB::select("SELECT * FROM products");
    // $products = DB::select("SELECT * FROM products WHERE price > 100");
    return view('query-test', compact('products'));
});

Route::get('query/builder', function () {
    $products = DB::table('products')->get();
    // $products = DB::table('products')->where('price', '>', 100)->get();
    return view('query-test', compact('products'));
});

Route::get('query/orm', function () {
    $products = Product::get();
    // $products = Product::where('price', '>', 100)->get();
    return view('query-test', compact('products'));
});



Route::get('barchart', function () {    
    return view('barchart');
})->name('barchart');


//ถ้ามีอroute เก่าให้ลบทิ้งถ้ามันซ้ำกันกับคอมเม้นนี้
Route::get('product-index', function () {
    $products = Product::get();
    return view('query-test', compact('products'));
})->name("product.index");


Route::get('product-form', function () {    
    return view('product-form');
})->name("product.form");
//--------------------------------------END--------------------------------

//-----------------------
Route::post('/product-submit', function (Request $request) {    
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);    

    // ตรวจสอบว่ามีการอัปโหลดรูปภาพ
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('uploads', 'public');
        $url = Storage::url($imagePath);
        $data["image"] =$url;
    }

    // บันทึกข้อมูลในฐานข้อมูล
    Product::create($data);

    return redirect()->route('product.index')->with('success', 'เพิ่มสินค้าแล้ว!');
})->name('product.submit');

//----ยาวมากระวังให้ดี คืออะไรก็ไม่รู้ 
use App\Models\Weight;

// ==================== WEIGHT ROUTES (CRUD) ====================

// 1. แสดงรายการน้ำหนัก
Route::get('weight-index', function () {
    $weights = Weight::orderBy('date', 'desc')->get();
    return view('weight-index', compact('weights'));
})->name("weight.index");

// 2. แสดงฟอร์มเพิ่มน้ำหนัก
Route::get('weight-form', function () {
    return view('weight-form');
})->name("weight.form");

// 3. บันทึกน้ำหนัก (POST)
Route::post('/weight-submit', function (Request $request) {
    $data = $request->validate([
        'date' => 'required|date',
        'weight' => 'required|numeric|min:0|max:999.99',
        'notes' => 'nullable|string|max:255',
    ]);

    Weight::create($data);
    return redirect()->route('weight.index')->with('success', 'เพิ่มข้อมูลน้ำหนักแล้ว!');
})->name('weight.submit');

// 4. แสดงฟอร์มแก้ไข
Route::get('weight-edit/{id}', function ($id) {
    $weight = Weight::findOrFail($id);
    return view('weight-form', compact('weight'));
})->name("weight.edit");

// 5. อัปเดตน้ำหนัก (PUT)
Route::put('/weight-update/{id}', function (Request $request, $id) {
    $weight = Weight::findOrFail($id);
    
    $data = $request->validate([
        'date' => 'required|date',
        'weight' => 'required|numeric|min:0|max:999.99',
        'notes' => 'nullable|string|max:255',
    ]);

    $weight->update($data);
    return redirect()->route('weight.index')->with('success', 'อัปเดตข้อมูลแล้ว!');
})->name('weight.update');

// 6. ลบน้ำหนัก (DELETE)
Route::delete('/weight-delete/{id}', function ($id) {
    $weight = Weight::findOrFail($id);
    $weight->delete();
    return redirect()->route('weight.index')->with('success', 'ลบข้อมูลแล้ว!');
})->name('weight.delete');