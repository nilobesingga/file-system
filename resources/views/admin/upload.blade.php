<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Upload Files
        </h2>
    </x-slot> --}}

    <div class="py-3">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                    <div class="mb-4 text-sm text-green-600 dark:text-green-400">
                        {{ session('success') }}
                    </div>
                @endif
            <div class="p-6 mb-2 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Upload Files</h3>
                <form action="{{ route('admin.upload') }}" method="POST" enctype="multipart/form-data" id="dropzoneForm" class="space-y-4">
                    @csrf
                    <div class="p-4 transition border-2 border-gray-400 border-dashed rounded-lg dropzone dark:border-gray-600 hover:border-gray-600 dark:hover:border-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700" id="dropzoneUpload">
                        <div class="flex flex-col items-center justify-center p-8 text-center dz-message needsclick">
                            <!-- Upload Icon -->
                            <svg class="w-12 h-12 mb-4 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                            </svg>

                            <!-- Dropzone Text -->
                            <p class="text-gray-600 dark:text-gray-300">Drag and drop files here, or click to select files</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Any file type allowed (max 10MB each)</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <x-input-label for="category_ids" :value="__('Categories')" />
                        <select name="category_id" id="category_id" data-choice class="block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>
                    <button type="submit" id="submitDropzone" class="inline-flex items-center hidden px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Upload Files
                    </button>
                    <div id="dropzoneErrors" class="hidden mt-2 text-sm text-red-600 dark:text-red-400"></div>
                </form>
            </div>
            <x-files-list :files="$files"/>
        </div>
    </div>
<!-- PDF.js Library -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dropzone.autoDiscover = false;
            const dropzone = new Dropzone('#dropzoneUpload', {
                url: '{{ route('admin.upload') }}',
                method: 'post',
                paramName: 'file', // Name of the file input
                maxFilesize: 10, // Max file size in MB
                acceptedFiles: null, // Accept any file type (remove PDF restriction)
                parallelUploads: 10, // Allow multiple uploads simultaneously
                uploadMultiple: true, // Enable multiple file uploads
                maxFiles: 10, // Limit total files uploaded at once
                autoProcessQueue: false, // Disable auto-upload; we'll handle submission manually
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                init: function () {
                    this.on('addedfile', function (file) {
                        console.log('Added file:', file);
                    });
                    this.on('error', function (file, errorMessage) {
                        if (file) {
                            document.getElementById('dropzoneErrors').textContent = errorMessage;
                            document.getElementById('dropzoneErrors').classList.remove('hidden');
                        }
                    });
                    this.on('successmultiple', function (files, response) {
                        if (response.success) {
                            window.location.reload(); // Refresh the page on success
                        } else {
                            document.getElementById('dropzoneErrors').textContent = response.message || 'Upload failed';
                            document.getElementById('dropzoneErrors').classList.remove('hidden');
                        }
                    });
                }
            });

            // Handle form submission manually
            document.getElementById('submitDropzone').addEventListener('click', function (e) {
                e.preventDefault();
                const categoryId = document.getElementById('category_id').value;
                if (!categoryId) {
                    document.getElementById('dropzoneErrors').textContent = 'Please select a category';
                    document.getElementById('dropzoneErrors').classList.remove('hidden');
                    return;
                }

                // Add category_id to the form data
                dropzone.options.params = { category_id: categoryId };
                dropzone.processQueue();
            });

            // Show submit button when files are added
            dropzone.on('addedfile', function () {
                document.getElementById('submitDropzone').classList.remove('hidden');
            });

            // Hide submit button and clear errors if no files
            dropzone.on('removedfile', function () {
                if (dropzone.files.length === 0) {
                    document.getElementById('submitDropzone').classList.add('hidden');
                    document.getElementById('dropzoneErrors').classList.add('hidden');
                    document.getElementById('dropzoneErrors').textContent = '';
                }
            });
        });
    </script>
    <style>
        .dropzone {
            border: 2px dashed #9ca3af !important; /* Tailwind's gray-400 */
                border-radius: 8px; /* Matches Tailwind's rounded-lg */
                padding: 1.5rem; /* Matches Tailwind's p-6 */
                background-color: transparent !important; /* Prevent Dropzone overrides */
            }

            .dropzone:hover {
                border-color: #4b5563 !important; /* Tailwind's gray-600 */
            }

            .dropzone .dz-message {
                color: #4b5563; /* Tailwind's text-gray-600 */
            }

    </style>
</x-app-layout>
