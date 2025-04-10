<x-app-layout>
    <div class="py-3">
        <div class="w-full mx-auto sm:px-6 lg:px-20">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Success/Error Messages -->
                    @if (session('success'))
                        <div class="p-4 mb-6 text-green-800 border-l-4 border-green-500 rounded bg-green-50">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="p-4 mb-6 text-red-800 border-l-4 border-red-500 rounded bg-red-50">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span>{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Upload Form -->
                    <form id="upload-form" action="{{ route('admin.investments.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-6">
                            <label for="file" class="block mb-2 text-sm font-medium text-gray-700">Upload CSV or XLSX File</label>
                            <div id="dropzone" class="p-6 text-center transition-colors duration-200 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-500">
                                <input type="file" name="file" id="file" accept=".csv,.xlsx" class="hidden" onchange="handleFileSelect(event)">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="text-gray-600">Drag and drop your file here, or</p>
                                    <button type="button" onclick="document.getElementById('file').click()" class="inline-flex items-center px-4 py-2 mt-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Browse Files
                                    </button>
                                    <p id="file-name" class="mt-2 text-sm text-gray-500"></p>
                                </div>
                            </div>
                            @error('file')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('admin.investments.template.download') }}" download class="flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download Template
                            </a>
                            <button type="submit" id="submit-btn" class="inline-flex items-center px-4 py-2 font-semibold text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span id="submit-text">Upload</span>
                                <svg id="loading-spinner" class="hidden w-5 h-5 ml-2 text-white animate-spin" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Instructions -->
                    <div class="mt-8">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Instructions</h3>
                        <div class="p-4 rounded-lg bg-gray-50">
                            <p class="mb-2 text-sm text-gray-600"><strong>Expected File Format:</strong></p>
                            <p class="mb-2 text-sm text-gray-600">Your file should contain the following columns:</p>
                            <ul class="mb-4 text-sm text-gray-600 list-disc list-inside">
                                <li>Investor Code</li>
                                <li>Investor Sub-account</li>
                                <li>Investor Name</li>
                                <li>Monthly Distribution</li>
                                <li>Bond Serie</li>
                                <li>Amount</li>
                                <li>Date</li>
                                <li>Transaction Type</li>
                                <li>Transaction</li>
                                <li>Month</li>
                                <li>Year</li>
                                <li>Explanation</li>
                            </ul>
                            <p class="mb-2 text-sm text-gray-600">Supported formats: <strong>CSV</strong> and <strong>XLSX</strong>.</p>
                            <p class="mb-2 text-sm text-gray-600">Maximum file size: <strong>10MB</strong>.</p>
                            <p class="text-sm text-gray-600">Not sure about the format? Download the template above to get started.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Drag-and-Drop and Loading Spinner -->
    <script>
        // Drag-and-Drop Functionality
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('file');
        const fileNameDisplay = document.getElementById('file-name');

        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('border-indigo-500', 'bg-indigo-50');
        });

        dropzone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-indigo-500', 'bg-indigo-50');
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-indigo-500', 'bg-indigo-50');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                fileNameDisplay.textContent = files[0].name;
            }
        });

        function handleFileSelect(event) {
            const files = event.target.files;
            if (files.length > 0) {
                fileNameDisplay.textContent = files[0].name;
            }
        }

        // Loading Spinner on Submit
        document.getElementById('upload-form').addEventListener('submit', function () {
            const submitBtn = document.getElementById('submit-btn');
            const submitText = document.getElementById('submit-text');
            const loadingSpinner = document.getElementById('loading-spinner');

            submitText.textContent = 'Uploading...';
            loadingSpinner.classList.remove('hidden');
            submitBtn.disabled = true;
        });
    </script>
</x-app-layout>
