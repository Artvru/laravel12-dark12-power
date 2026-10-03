<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $customer->exists ? 'แก้ไขข้อมูลลูกค้า' : 'เพิ่มลูกค้า' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <main class="mx-auto max-w-2xl px-4 py-10 sm:px-6">
        <a href="{{ $customer->exists ? route('customers.show', $customer) : route('customers.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">← กลับ</a>
        <section class="mt-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <h1 class="text-2xl font-bold">{{ $customer->exists ? 'แก้ไขข้อมูลลูกค้า' : 'เพิ่มลูกค้าใหม่' }}</h1>
            <p class="mt-1 text-sm text-slate-500">กรอกข้อมูลสำหรับติดต่อและติดตามประวัติการซื้อ</p>

            @if ($errors->any())
                <div class="mt-5 rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                    <p class="font-semibold">กรุณาตรวจสอบข้อมูล</p>
                    <ul class="mt-2 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form method="POST" action="{{ $customer->exists ? route('customers.update', $customer) : route('customers.store') }}" class="mt-6 space-y-5">
                @csrf
                @if ($customer->exists) @method('PUT') @endif
                <div>
                    <label for="name" class="mb-1 block text-sm font-medium">ชื่อ-นามสกุล <span class="text-rose-600">*</span></label>
                    <input id="name" name="name" value="{{ old('name', $customer->name) }}" required maxlength="255" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('name')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="mb-1 block text-sm font-medium">อีเมล <span class="text-rose-600">*</span></label>
                    <input id="email" name="email" type="email" value="{{ old('email', $customer->email) }}" required maxlength="255" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('email')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="phone" class="mb-1 block text-sm font-medium">เบอร์โทรศัพท์ <span class="text-rose-600">*</span></label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone', $customer->phone) }}" required maxlength="50" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('phone')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="address" class="mb-1 block text-sm font-medium">ที่อยู่ (ไม่บังคับ)</label>
                    <textarea id="address" name="address" rows="3" maxlength="2000" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address', $customer->address) }}</textarea>
                    @error('address')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div class="flex justify-end gap-3 border-t border-slate-100 pt-5">
                    <a href="{{ $customer->exists ? route('customers.show', $customer) : route('customers.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">ยกเลิก</a>
                    <button class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">บันทึกข้อมูล</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
