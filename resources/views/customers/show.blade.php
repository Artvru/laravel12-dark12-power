<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $customer->name }} | ลูกค้า</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <main class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
        <a href="{{ route('customers.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">← รายชื่อลูกค้า</a>
        @if (session('success'))<div class="mt-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>@endif

        <section class="mt-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">ข้อมูลลูกค้า</p>
                    <h1 class="mt-1 text-3xl font-bold">{{ $customer->name }}</h1>
                    <dl class="mt-4 grid gap-x-8 gap-y-3 text-sm sm:grid-cols-2">
                        <div><dt class="text-slate-500">อีเมล</dt><dd class="mt-0.5 font-medium">{{ $customer->email }}</dd></div>
                        <div><dt class="text-slate-500">เบอร์โทรศัพท์</dt><dd class="mt-0.5 font-medium">{{ $customer->phone }}</dd></div>
                        <div class="sm:col-span-2"><dt class="text-slate-500">ที่อยู่</dt><dd class="mt-0.5 whitespace-pre-line font-medium">{{ $customer->address ?: '—' }}</dd></div>
                    </dl>
                </div>
                <a href="{{ route('customers.edit', $customer) }}" class="inline-flex shrink-0 justify-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">แก้ไขข้อมูล</a>
            </div>
        </section>

        <div class="mt-7 grid gap-6 lg:grid-cols-[minmax(0,1fr)_20rem]">
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                    <h2 class="font-bold">ประวัติการซื้อ</h2><span class="text-sm text-slate-500">{{ $customer->purchaseHistories->count() }} รายการ</span>
                </div>
                @if ($customer->purchaseHistories->isEmpty())
                    <p class="px-5 py-10 text-center text-sm text-slate-500">ยังไม่มีประวัติการซื้อ</p>
                @else
                    <ul class="divide-y divide-slate-100">
                        @foreach ($customer->purchaseHistories as $purchase)
                            <li class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="font-medium">{{ $purchase->description }}</p>
                                    <p class="mt-1 text-sm text-slate-500">{{ $purchase->purchase_date->format('d/m/Y') }}</p>
                                </div>
                                <div class="flex items-center justify-between gap-4 sm:justify-end">
                                    <span class="font-semibold tabular-nums">฿{{ number_format((float) $purchase->amount, 2) }}</span>
                                    <form method="POST" action="{{ route('customers.purchases.destroy', [$customer, $purchase]) }}" onsubmit="return confirm('ยืนยันลบประวัติการซื้อนี้หรือไม่?')">
                                        @csrf @method('DELETE')
                                        <button class="text-sm font-medium text-rose-600 hover:text-rose-800">ลบ</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>

            <section class="h-fit rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="font-bold">เพิ่มประวัติการซื้อ</h2>
                @if ($errors->any())
                    <div class="mt-4 rounded-lg bg-rose-50 p-3 text-sm text-rose-700">@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>
                @endif
                <form method="POST" action="{{ route('customers.purchases.store', $customer) }}" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label for="description" class="mb-1 block text-sm font-medium">รายละเอียด</label>
                        <textarea id="description" name="description" rows="3" required maxlength="2000" class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    </div>
                    <div>
                        <label for="amount" class="mb-1 block text-sm font-medium">ยอดซื้อ (บาท)</label>
                        <input id="amount" name="amount" type="number" min="0" max="999999999.99" step="0.01" value="{{ old('amount', '0.00') }}" required class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="purchase_date" class="mb-1 block text-sm font-medium">วันที่ซื้อ</label>
                        <input id="purchase_date" name="purchase_date" type="date" value="{{ old('purchase_date', now()->toDateString()) }}" required class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <button class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">บันทึกประวัติการซื้อ</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
