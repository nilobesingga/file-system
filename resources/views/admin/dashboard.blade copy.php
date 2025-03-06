<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- File System Widget -->
                {{-- <x-user-file-system-widget
                    :totalFiles="$files->count()"
                    :storageUsage="Storage::disk('public')->size('files')"
                    :recentUploadsCount="File::where('created_at', '>=', now()->subDays(7))->count()"
                /> --}}

                <!-- Category Management -->
                <div id="category-list" class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Manage Categories</h3>
                    <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" required>
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" id="description" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"></textarea>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Create Category
                        </button>
                    </form>

                    <div class="mt-6">
                        <h4 class="text-md font-semibold text-gray-900 dark:text-gray-100 mb-2">Existing Categories</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($categories as $category)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $category->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $category->description ?? 'No description' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('categories.update', $category->id) }}" class="inline-flex items-center px-3 py-1 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 text-sm">Edit</a>
                                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- User-Category Assignments -->
                <div id="assign-users" class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Assign Users to Categories</h3>
                    <form action="{{ route('categories.assign') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select User</label>
                            <select name="user_id" id="user_id" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="category_ids" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Categories (Multiple)</label>
                            <select name="category_ids[]" id="category_ids" multiple class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Assign
                        </button>
                    </form>

                    <div class="mt-6">
                        <h4 class="text-md font-semibold text-gray-900 dark:text-gray-100 mb-2">Remove User from Categories</h4>
                        <form action="{{ route('categories.remove') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="user_id_remove" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select User</label>
                                <select name="user_id" id="user_id_remove" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="category_ids_remove" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Categories (Multiple)</label>
                                <select name="category_ids[]" id="category_ids_remove" multiple class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>

                <!-- File Upload Form -->
                <div id="upload-files" class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Upload Files</h3>
                    <form action="{{ route('admin.upload') }}" method="POST" enctype="multipart/form-data" id="dropzoneForm" class="space-y-4">
                        @csrf
                        <div class="dropzone" id="dropzoneUpload">
                            <div class="dz-message needsclick">
                                <p class="text-gray-600 dark:text-gray-300">Drag and drop files here, or click to select files</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Any file type allowed (max 10MB each)</p>
                            </div>
                        </div>
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Category</label>
                            <select name="category_id" id="category_id" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" id="submitDropzone" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hidden">
                            Upload Files
                        </button>
                        <div id="dropzoneErrors" class="mt-2 text-sm text-red-600 dark:text-red-400 hidden"></div>
                    </form>
                </div>

                <!-- Uploaded Files Table -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Uploaded Files</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">File Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Uploaded By</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Upload Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Size</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($files as $file)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $file->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $file->category ? $file->category->name : 'Uncategorized' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $file->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $file->created_at->format('F d, Y h:i A') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">0 KB</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        <div class="flex space-x-2">
                                            <!-- Preview Button (for PDFs only) -->
                                            @if(str_ends_with($file->path, '.pdf'))
                                                <button onclick="previewPDF('{{ Storage::url($file->path) }}')" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                                                    Preview
                                                </button>
                                            @endif
                                            <!-- Download Button -->
                                            <a href="{{ Storage::url($file->path) }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                                                Download
                                            </a>
                                            <!-- Delete Button -->
                                            <form action="{{ route('file.destroy', $file->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm" onclick="return confirm('Are you sure you want to delete this file?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- No Files Message -->
                    @if($files->isEmpty())
                    <p class="text-gray-600 dark:text-gray-300 mt-4">No files uploaded yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- PDF Preview Modal -->
    <div id="pdfModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-3/4 h-3/4 overflow-auto">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">PDF Preview</h3>
            <button onclick="closePDF()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100">×</button>
            <iframe id="pdfViewer" class="w-full h-full" frameborder="0"></iframe>
        </div>
    </div>

<!-- JavaScript for PDF Preview -->
<script>
    function previewPDF(url) {
        const modal = document.getElementById('pdfModal');
        const pdfViewer = document.getElementById('pdfViewer');
        pdfViewer.src = url;
        modal.classList.remove('hidden');
    }

    function closePDF() {
        const modal = document.getElementById('pdfModal');
        const pdfViewer = document.getElementById('pdfViewer');
        pdfViewer.src = '';
        modal.classList.add('hidden');
    }
</script>
    <!-- JavaScript for Dropzone -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
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

<!-- Dropzone CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7T1YKKGvtzK+huaDfbV7SnU0F9ha0x1cv0g8b6WCLP1B9pUFljA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</x-app-layout>
