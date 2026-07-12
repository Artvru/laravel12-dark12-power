@extends('master')

@section('title', 'Gallery')

@section('content')
    <div class="text-center py-6">
        <h1 class="text-3xl font-bold text-amber-500 mb-8">Superhero Gallery</h1>
        <h2 class="text-2xl font-bold text-amber-120 mb-8">ธีรรักษ์ จิรภานันท์ 67Jac000001</h2>
        
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            <div class="bg-gray-900 p-4 rounded-lg border border-gray-700 hover:border-amber-500 transition shadow-md">

                <a href="/gallery/ant">
                    <img src="https://cdn3.movieweb.com/i/article/Oi0Q2edcVVhs4p1UivwyyseezFkHsq/1107:50/Ant-Man-3-Talks-Michael-Douglas-Update.jpg" alt="Ant" class="w-full h-40 object-cover rounded mb-4">
                    <span class="text-lg font-semibold text-gray-200">Ant</span>
                </a>
            </div>

            <div class="bg-gray-900 p-4 rounded-lg border border-gray-700 hover:border-amber-500 transition shadow-md">
                <a href="/gallery/bird">
                    <img src="https://f.ptcdn.info/985/030/000/1430668948-43-o.jpg" alt="Bird" class="w-full h-40 object-cover rounded mb-4">
                    <span class="text-lg font-semibold text-gray-200">Bird</span>
                </a>
            </div>

            <div class="bg-gray-900 p-4 rounded-lg border border-gray-700 hover:border-amber-500 transition shadow-md">
                <a href="/gallery/cat">
                    <img src="https://media.newyorker.com/photos/5a875e3f33aebd0cab9bab12/master/w_2560%2Cc_limit/Brody-Passionate-Politics-Black-Panther.jpg" alt="Cat" class="w-full h-40 object-cover rounded mb-4">
                    <span class="text-lg font-semibold text-gray-200">Cat</span>
                </a>
            </div>
        </div>
    </div>
@endsection