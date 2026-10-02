<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit About Me</title>
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
    
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 max-w-2xl mx-auto">
        
        <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-200 dark:border-gray-700">
            <h1 class="text-3xl font-extrabold tracking-tight">Edit Profile</h1>
            <div class="flex space-x-4 items-center">
                <!-- Theme Toggle Button -->
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 mr-2">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                </button>
                <a href="{{ route('about-me.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">Cancel</a>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 text-red-700 p-4 rounded shadow-sm border-l-4 border-red-500 dark:bg-red-900 dark:text-red-200">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden p-8">
            <form action="{{ route('about-me.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                    <input type="text" name="name" id="name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" value="{{ old('name', $aboutMe?->name) }}" placeholder="e.g. John Doe">
                </div>

                <!-- Student ID -->
                <div class="mb-6">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Student ID</label>
                    <input type="text" name="student_id" id="student_id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" value="{{ old('student_id', $aboutMe?->student_id) }}" placeholder="e.g. 64010001">
                </div>

                <!-- Current Image / Upload -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Profile Photo</label>
                    
                    <!-- Preview Container -->
                    <div id="preview-wrapper" class="mb-4 flex flex-col items-center sm:items-start">
                        <span class="block text-xs text-gray-400 mb-2" id="preview-label">
                            {{ $aboutMe?->image_path ? 'Current Photo:' : 'Selected Photo Preview:' }}
                        </span>
                        <img id="image-preview" src="{{ $aboutMe?->image_path ? asset($aboutMe->image_path) : '' }}" class="h-32 w-32 object-cover rounded-full border-4 border-gray-200 dark:border-gray-600 shadow-sm {{ $aboutMe?->image_path ? '' : 'hidden' }}" alt="Profile preview">
                    </div>
                    
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-indigo-500 transition-colors">
                        <div class="space-y-2 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                <label for="image" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 px-2 py-1 border border-indigo-200 dark:border-indigo-800">
                                    <span id="file-label-text">Choose / Upload a photo</span>
                                    <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewSelectedImage(event)">
                                </label>
                            </div>
                            <p id="file-name-display" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hidden"></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Save Changes
                    </button>
                </div>
            </form>
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

        // Image Preview Handler
        function previewSelectedImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgPreview = document.getElementById('image-preview');
                    const previewLabel = document.getElementById('preview-label');
                    const fileNameDisplay = document.getElementById('file-name-display');
                    const fileLabelText = document.getElementById('file-label-text');

                    imgPreview.src = e.target.result;
                    imgPreview.classList.remove('hidden');
                    previewLabel.textContent = 'Selected Photo Preview:';
                    
                    fileNameDisplay.textContent = '📷 Selected: ' + file.name;
                    fileNameDisplay.classList.remove('hidden');

                    fileLabelText.textContent = 'Change Selected Photo';
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
