<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Check local storage or system preference before rendering to prevent FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-900 antialiased dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">
    
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-10 pb-4 border-b border-gray-200 dark:border-gray-700">
            <h1 class="text-3xl font-extrabold tracking-tight">About Me</h1>
            <div class="flex space-x-4 items-center">
                <a href="{{ route('customers.index') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition shadow-sm">
                    จัดการลูกค้า
                </a>
                <!-- Theme Toggle Button -->
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 mr-2">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                </button>
                @auth
                    <a href="{{ route('about-me.edit') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                        Edit Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 font-medium">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition">
                        Log in to Edit
                    </a>
                @endauth
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm dark:bg-green-900 dark:text-green-200" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Profile Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden mb-12 transform hover:-translate-y-1 transition duration-300">
            <div class="md:flex">
                <div class="md:shrink-0 bg-gray-100 dark:bg-gray-700 flex items-center justify-center p-8">
                    @if($aboutMe && $aboutMe->image_path)
                        <img class="h-48 w-48 object-cover rounded-full border-4 border-white shadow-lg dark:border-gray-600" src="{{ asset($aboutMe->image_path) }}" alt="Profile Photo">
                    @else
                        <div class="h-48 w-48 rounded-full border-4 border-dashed border-gray-300 dark:border-gray-500 flex items-center justify-center text-gray-400 bg-gray-50 dark:bg-gray-800 shadow-inner">
                            <span class="text-sm font-medium">No Image</span>
                        </div>
                    @endif
                </div>
                <div class="p-8 flex flex-col justify-center">
                    <div class="uppercase tracking-wide text-sm text-indigo-600 dark:text-indigo-400 font-bold mb-1">Student Profile</div>
                    <h2 class="block mt-1 text-3xl leading-tight font-extrabold text-gray-900 dark:text-white">
                        {{ $aboutMe->name ?? 'Update Your Name' }}
                    </h2>
                    <p class="mt-4 text-xl text-gray-500 dark:text-gray-300">
                        <span class="font-semibold">Student ID:</span> {{ $aboutMe->student_id ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Portfolios Section -->
        <div>
            <h3 class="text-2xl font-bold mb-6 pb-2 border-b border-gray-200 dark:border-gray-700">My Works</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- EP02 Hero -->
                <a href="{{ url('/gallery') }}" class="group block p-6 bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-xl hover:ring-2 hover:ring-indigo-500 transition duration-200">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 w-12 h-12 rounded-lg flex items-center justify-center font-bold text-xl">
                            02
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400">EP02 Hero</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Gallery System (Route: /gallery)</p>
                        </div>
                    </div>
                </a>

                <!-- EP03 Active Bootstrap -->
                <a href="{{ url('/active/index') }}" class="group block p-6 bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-xl hover:ring-2 hover:ring-indigo-500 transition duration-200">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 w-12 h-12 rounded-lg flex items-center justify-center font-bold text-xl">
                            03
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400">EP03 Active Bootstrap</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Active Theme (Route: /active/index)</p>
                        </div>
                    </div>
                </a>

                <!-- EP07 Weight -->
                <a href="{{ url('/weights') }}" class="group block p-6 bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-xl hover:ring-2 hover:ring-indigo-500 transition duration-200">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 w-12 h-12 rounded-lg flex items-center justify-center font-bold text-xl">
                            07
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400">EP07 Weight System</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                Secured Area (Route: /weights)
                                <svg class="w-4 h-4 ml-1 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </p>
                        </div>
                    </div>
                </a>

                <!-- EP08 Auth -->
                <a href="{{ route('login') }}" class="group block p-6 bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-xl hover:ring-2 hover:ring-indigo-500 transition duration-200">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 bg-orange-100 dark:bg-orange-900 text-orange-600 dark:text-orange-300 w-12 h-12 rounded-lg flex items-center justify-center font-bold text-xl">
                            08
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400">EP08 Authentication</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Login Page / Dashboard</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        
    </div>

    <!-- Theme Mode toggle script -->
    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Change the icons inside the button based on previous settings
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            // toggle icons inside button
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // if set via local storage previously
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });
    </script>
</body>
</html>
