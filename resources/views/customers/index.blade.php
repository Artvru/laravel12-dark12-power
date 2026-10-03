<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการลูกค้า</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <header class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('about-me.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">← กลับหน้า About Me</a>
                <h1 class="mt-2 text-3xl font-bold tracking-tight">จัดการลูกค้า</h1>
                <p class="mt-1 text-sm text-slate-500">จัดเก็บข้อมูลและประวัติการซื้อของลูกค้า</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('customers.export', request()->query()) }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-100">ส่งออก CSV (เปิดด้วย Excel ได้)</a>
                <a href="{{ route('customers.create') }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">+ เพิ่มลูกค้า</a>
            </div>
        </header>

        @if (session('success'))
            <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <form method="GET" action="{{ route('customers.index') }}" class="flex flex-col gap-3 border-b border-slate-200 p-4 sm:flex-row">
                <label for="search" class="sr-only">ค้นหาชื่อหรือเบอร์โทรศัพท์</label>
                <input id="search" name="search" value="{{ $search }}" type="search" placeholder="ค้นหาด้วยชื่อหรือเบอร์โทรศัพท์" class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-md">
                <div class="flex gap-2">
                    <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">ค้นหา</button>
                    @if ($search !== '')
                        <a href="{{ route('customers.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">ล้าง</a>
                    @endif
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3 font-semibold">ลูกค้า</th>
                            <th class="px-5 py-3 font-semibold">เบอร์โทรศัพท์</th>
                            <th class="px-5 py-3 font-semibold">ประวัติการซื้อ</th>
                            <th class="px-5 py-3 text-right font-semibold">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($customers as $customer)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4">
                                    <a href="{{ route('customers.show', $customer) }}" class="font-semibold text-slate-900 hover:text-indigo-700">{{ $customer->name }}</a>
                                    <div class="mt-1 text-slate-500">{{ $customer->email }}</div>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-slate-600">{{ $customer->phone }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-slate-600">{{ $customer->purchase_histories_count }} รายการ</td>
                                <td class="whitespace-nowrap px-5 py-4 text-right">
                                    <a href="{{ route('customers.edit', $customer) }}" class="font-medium text-indigo-600 hover:text-indigo-800">แก้ไข</a>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="ml-3 inline" onsubmit="return confirm('ยืนยันลบลูกค้ารายนี้และประวัติการซื้อทั้งหมดหรือไม่?')">
                                        @csrf @method('DELETE')
                                        <button class="font-medium text-rose-600 hover:text-rose-800">ลบ</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-5 py-12 text-center text-slate-500">{{ $search !== '' ? 'ไม่พบลูกค้าที่ตรงกับคำค้นหา' : 'ยังไม่มีข้อมูลลูกค้า เริ่มเพิ่มลูกค้ารายแรกได้เลย' }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($customers->hasPages())
                <div class="border-t border-slate-200 p-4">{{ $customers->links() }}</div>
            @endif
        </section>
    </main>
</body>
</html>
