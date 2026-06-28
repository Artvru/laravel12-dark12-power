@extends('master')

@section('title', 'Cat')

@section('content')
    <div class="text-center py-6 max-w-xl mx-auto">
        <h1 class="text-3xl font-bold text-purple-500 mb-4">Cat of Teerarak Jirapanan</h1>
        <img src="https://media.newyorker.com/photos/5a875e3f33aebd0cab9bab12/master/w_2560%2Cc_limit/Brody-Passionate-Politics-Black-Panther.jpg" alt="Cat" class="w-full rounded-lg shadow-lg mb-6">
        <p class="text-gray-300 mb-6">Cat แมวตัวนี้แปกๆ</p>
        <a href="/gallery" class="inline-block bg-gray-700 text-gray-200 px-4 py-2 rounded hover:bg-gray-600 transition">Back to Gallery</a>
    </div>
@endsection