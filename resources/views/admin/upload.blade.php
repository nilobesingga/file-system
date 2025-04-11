<x-app-layout>
    <div class="py-3">
        <div class="w-full mx-auto sm:px-6 lg:px-20">
            @if (session('success'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif
            <div class="mb-4 overflow-hidden bg-white shadow-sm p-7 sm:rounded-lg">
                <h3 class="mb-4 text-2xl font-semibold text-gray-900">Upload Files</h3>
                <form action="{{ route('admin.upload') }}" method="POST" enctype="multipart/form-data" id="dropzoneForm" class="space-y-4">
                    @csrf
                    <div class="flex flex-row gap-2 mt-4">
                        <div class="sm:w-1/2">
                            <x-input-label for="user_id" class="mb-2" :value="__('Select Investor *')" required />
                            <x-user-multi-select required/>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2" id="user_id_error" />
                        </div>
                        <div class="sm:w-1/2">
                            <x-input-label for="category_ids" class="" :value="__('Categories *')" />
                            <select name="category_id" id="category_id" data-choice class="block w-full mt-1 text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring-sky-500" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>
                    </div>
                    <!-- Document Name Input Field -->
                    <div class="flex flex-row gap-2 mt-4">
                        <div class="sm:w-1/2">
                            <x-input-label for="document_name" class="" :value="__('Bond Name *')" />
                            <x-text-input
                                id="document_name"
                                name="document_name"
                                type="text"
                                class="block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg focus:outline-none"
                                placeholder="Enter bond name"
                                required
                            />
                            <x-input-error :messages="$errors->get('document_name')" class="mt-2" id="document_name_error" />
                        </div>
                        <div class="sm:w-1/2">
                            <x-input-label for="statement_no" class="" :value="__('Statement # *')" />
                            <x-text-input
                                id="statement_no"
                                name="statement_no"
                                type="text"
                                class="block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg focus:outline-none"
                                placeholder="Enter statement number"
                                required
                            />
                            <x-input-error :messages="$errors->get('statement_no')" class="mt-2" id="statement_no_error" />
                        </div>
                        <div class="sm:w-1/2">
                            <x-input-label for="statement_period" class="" :value="__('Statement Period *')" />
                            <input type="date" id="statement_period" name="statement_period" class="block w-full mt-1 text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring-sky-500" required>
                            <x-input-error :messages="$errors->get('statement_period')" class="mt-2" id="statement_period_error" />
                        </div>
                    </div>
                    <div class="flex flex-row hidden gap-2 mt-4">
                        <div class="sm:w-1/2">
                            <x-input-label for="number_of_bonds" class="" :value="__('Number of Bonds *')" />
                            <x-text-input
                                id="number_of_bonds"
                                name="number_of_bonds"
                                value="0"
                                type="text"
                                class="block w-full mt-1 text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring-sky-500"
                                placeholder="Enter number of bonds"
                                required
                            />
                            <x-input-error :messages="$errors->get('number_of_bonds')" class="mt-2" id="number_of_bonds_error" />
                        </div>
                        <div class="sm:w-1/2">
                            <x-input-label for="amount_subscribed" class="" :value="__('Amount Subscribed *')" />
                            <x-text-input
                                id="amount_subscribed"
                                name="amount_subscribed"
                                value="0.00"
                                type="text"
                                class="block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg focus:outline-none"
                                placeholder="0.00"
                                required
                            />
                            <x-input-error :messages="$errors->get('amount_subscribed')" class="mt-2" id="amount_subscribed_error" />
                        </div>
                        <div class="sm:w-1/2">
                            <x-input-label for="currency" class="" :value="__('Currency *')" />
                            <select name="currency" id="currency" data-choice class="block w-full mt-1 text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring-sky-500" required>
                                <option value="">Select Currency</option>
                                <option value="USD" selected>USD</option>
                                <option value="AED">AED</option>
                            </select>
                            <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                        </div>
                    </div>
                    <x-input-label for="category_ids" class="" :value="__('Attach Documents')" />
                    <div class="p-4 transition border-2 border-yellow-800 border-dashed rounded-lg dropzone hover:border-yellow-600 hover:bg-yellow-100" id="dropzoneUpload">
                        <div class="flex flex-col items-center justify-center p-2 text-center dz-message needsclick">
                            <!-- Upload Icon -->
                            <svg class="w-12 h-12 mb-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                            </svg>

                            <!-- Dropzone Text -->
                            <p class="text-gray-600">Drag and drop files here, or click to select files</p>
                            <p class="text-sm text-gray-500">Any file type allowed (max 10MB each)</p>
                        </div>
                    </div>
                    <button type="submit" id="submitDropzone" class="inline-flex items-center hidden px-4 py-2 text-white rounded-md bg-customBlue hover:bg-customBlue/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-bg-customBlue/90">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        Upload Files
                    </button>
                    <div id="dropzoneErrors" class="hidden mt-2 text-sm text-red-600"></div>
                </form>
            </div>
            <x-files-list :files="$files" :category="$categories"/>
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
                            const documentNameError = document.getElementById('document_name_error');
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

                // Get all form inputs with null checks
                const userId = document.getElementById('user_id')?.value || '';
                // const userId = userSelect ? userSelect.value : '';
                const documentName = document.getElementById('document_name')?.value || '';
                const statementNo = document.getElementById('statement_no')?.value || '';
                const statementPeriod = document.getElementById('statement_period')?.value || '';
                const numberOfBonds = document.getElementById('number_of_bonds')?.value || '';
                const amountSubscribed = document.getElementById('amount_subscribed')?.value || '';
                const categoryId = document.getElementById('category_id')?.value || '';
                const currency = document.getElementById('currency')?.value || '';

                // Validation messages for each field
                const validationMessages = {
                    user_id: 'Please select an investor',
                    document_name: 'Please enter bond name',
                    statement_no: 'Please enter statement number',
                    statement_period: 'Please select statement period',
                    number_of_bonds: 'Please enter number of bonds',
                    amount_subscribed: 'Please enter amount subscribed',
                    category_id: 'Please select a category',
                    currency: 'Please select a currency'
                };

                // Check each field and handle null values
                const formFields = {
                    user_id: userId,
                    document_name: documentName,
                    statement_no: statementNo,
                    statement_period: statementPeriod,
                    number_of_bonds: numberOfBonds,
                    amount_subscribed: amountSubscribed,
                    category_id: categoryId,
                    currency: currency
                };

                const emptyField = Object.entries(formFields).find(([_, value]) => !value || value.trim() === '');

                if (emptyField) {
                    const errorElement = document.getElementById('dropzoneErrors');
                    errorElement.textContent = validationMessages[emptyField[0]];
                    errorElement.classList.remove('hidden');
                    return;
                }

                // Add all form data to the dropzone params
                dropzone.options.params = {
                    user_id: userId,
                    category_id: categoryId,
                    document_name: documentName,
                    statement_no: statementNo,
                    statement_period: statementPeriod,
                    number_of_bonds: numberOfBonds,
                    amount_subscribed: amountSubscribed,
                    currency: currency
                };
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
