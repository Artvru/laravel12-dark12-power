@extends('master')

@section('title', 'เกี่ยวกับเรา')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-amber-500 mb-6 border-b border-gray-700 pb-2">📜 ประวัติศาสตร์นครดาร์ก 12</h1>
        <p class="text-gray-300 leading-relaxed mb-4">
            นครแห่งนี้ถูกสถาปนาขึ้นโดยจอมเวทผู้สืบทอดพลัง เพื่อก้าวข้ามผ่านลูปนรกและพิชิตสถาปัตยกรรม Laravel 12 ยุคใหม่ 
            เราไม่ได้ใช้พลังงานโบราณอย่าง Webpack Mix อีกต่อไป แต่เราขับเคลื่อนเมืองด้วยเตาปฏิกรณ์ความเร็วแสงที่เรียกว่า **Vite**!
        </p>
        <p class="text-gray-400 italic">
            "ในความมืดมิด มีโค้ดสีเขียวที่รันผ่านฉลุยส่องสว่างอยู่เสมอ..."
        </p>

        <div class="mt-8 bg-gray-900 p-4 rounded-lg border border-amber-500/30">
            <h3 class="text-xl font-bold text-amber-400 mb-3">🛡️ รายนามสมุนเฝ้าประตูนครดาร์ก 12 (Data from Route):</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-300">
                @foreach($guards as $guard)
                    <li class="hover:text-amber-300 transition cursor-pointer">🔮 {{ $guard }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection