<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark 12 Power - @yield('title')</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-900 text-gray-100 font-sans">

    <nav class="bg-gray-800 p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-xl font-bold text-amber-500">🔮 DARK-12 PORTAL</a>
            <div class="space-x-4">
                <a href="/" class="hover:text-amber-400 transition">หน้าแรก</a>
                <a href="/about" class="hover:text-amber-400 transition">เกี่ยวกับเรา</a>
                <a href="/contact" class="hover:text-amber-400 transition">ติดต่อเรา</a>
                <a href="/hello" class="bg-amber-500 text-gray-900 font-bold px-3 py-1.5 rounded hover:bg-amber-400 transition shadow-md">👋 ทักทาย Hello</a>
                <a href="/gallery" class="hover:text-amber-400 text-gray-300 transition px-3 py-1.5">🖼️ คลังภาพ Gallery</a>
            </div>
        </div>
        </div>
    </nav>

    <main class="container mx-auto mt-10 p-6 bg-gray-800 rounded-lg shadow-xl min-h-[50vh]">
        @yield('content')
    </main>

    <footer class="bg-gray-950 text-center p-4 mt-10 text-gray-500 text-sm border-t border-gray-800">
        2026 นครดาร์ก 12 พาวเวอร์.
    </footer>

</body>

</html>