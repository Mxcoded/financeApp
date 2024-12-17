<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Files') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-lg font-semibold mb-4">Upload New Files</h1>

                    <!-- File Upload Form -->
                    <form id="uploadForm" action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="files" class="block text-gray-700 font-medium mb-2">Choose Files</label>
                            <input type="file" name="files[]" id="files" multiple 
                                   class="border border-gray-300 p-2 rounded w-full" required>
                            @error('files.*')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Progress Bar -->
                        <div class="w-full mb-4">
                            <div id="progressWrapper" class="hidden">
                                <label for="progress" class="block text-gray-700 font-medium">Upload Progress</label>
                                <div class="relative pt-1">
                                    <div class="flex mb-2 items-center justify-between">
                                        <span class="text-xs font-semibold inline-block py-1 uppercase">0%</span>
                                    </div>
                                    <div class="flex mb-2">
                                        <div id="progress" class="progress-bar w-0 h-2 bg-green-500 rounded"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Upload Files
                            </button>
                            <button type="reset" 
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Clear
                            </button>
                        </div>
                    </form>

                    <!-- Back to Files Link -->
                    <div class="mt-4">
                        <a href="{{ route('files.index') }}" class="text-blue-500 hover:underline">
                            &larr; Back to Files
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add event listener to handle form submission with AJAX
        const form = document.getElementById('uploadForm');
        const progressWrapper = document.getElementById('progressWrapper');
        const progressBar = document.getElementById('progress');
        const progressLabel = progressWrapper.querySelector('span');
        
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission
            
            // Show progress bar
            progressWrapper.classList.remove('hidden');
            progressBar.style.width = '0%';
            progressLabel.textContent = '0%';

            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();
            
            // Setup AJAX request
            xhr.open('POST', form.action, true);

            // Handle progress
            xhr.upload.onprogress = function (e) {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = percent + '%';
                    progressLabel.textContent = percent + '%';
                }
            };

            // Handle request completion (success or failure)
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    progressBar.style.width = '100%';
                    progressBar.classList.remove('bg-red-500');
                    progressBar.classList.add('bg-green-500');
                    progressLabel.textContent = 'Upload Complete';
                } else {
                    progressBar.style.width = '100%';
                    progressBar.classList.remove('bg-green-500');
                    progressBar.classList.add('bg-red-500');
                    progressLabel.textContent = 'Upload Failed';
                }
            };

            // Send the AJAX request
            xhr.send(formData);
        });
    </script>
</x-app-layout>
