<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
    <!-- Search Bar with Loading Indicator -->
    <div class="flex justify-between items-center mb-4 relative">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Files</h3>

        <div class="relative">
            <input type="text" id="searchInput" onkeyup="searchTable()"
                   placeholder="Search files..."
                   class="px-4 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100">

            <!-- Loading Spinner -->
            <div id="loadingSpinner" class="hidden absolute right-3 top-1/2 transform -translate-y-1/2">
                <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0116 0"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Uploaded Files Table -->
    <div class="overflow-x-auto">
        <table id="filesTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
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
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $file->category ? $file->category->name : 'Uncategorized' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $file->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $file->created_at->format('F d, Y h:i A') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ \App\Helpers\FileHelper::getFileSize($file->path) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                        <div class="flex space-x-2">
                            <!-- Preview Button -->
                            <button onclick="previewFile('{{ asset('storage/' . $file->path) }}', '{{ Storage::mimeType($file->path) }}')"
                                class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                                Preview
                            </button>
                            <!-- Download Button -->
                            <a href="{{ route('file.download', $file) }}" class="inline-flex items-center px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                                Download
                            </a>
                            @if(Auth::check() && Auth::user()->is_admin && Route::currentRouteName() !== 'dashboard')
                                <form action="{{ route('file.destroy', $file->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm" onclick="return confirm('Are you sure you want to delete this file?')">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $files->links() }}  <!-- Laravel Pagination -->
    </div>
    <!-- No Files Message -->
    @if($files->isEmpty())
    <p class="text-gray-600 dark:text-gray-300 mt-4">No files uploaded yet.</p>
    @endif
</div>


<!-- File Preview Modal -->
<div id="filePreviewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-3/4 max-w-4xl overflow-auto relative">
        <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">File Preview</h3>
        <button onclick="closePreview()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100 p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div id="fileViewer" class="w-full h-[500px] overflow-auto"></div>
        <div class="mt-4 flex justify-end">
            <button onclick="closePreview()" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                Close
            </button>
        </div>
    </div>
</div>

<!-- JavaScript for PDF Preview -->
<script>
    let searchTimeout;
    function searchTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toLowerCase();
        let table = document.getElementById("filesTable");
        let rows = table.getElementsByTagName("tr");
        let spinner = document.getElementById("loadingSpinner");

        // Show the loading spinner
        spinner.classList.remove("hidden");

        // Clear the previous timeout (debouncing)
        clearTimeout(searchTimeout);

        // Delay the execution of filtering for smooth experience
        searchTimeout = setTimeout(() => {
            for (let i = 1; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName("td");
                let rowMatch = false;

                for (let j = 0; j < cells.length; j++) {
                    if (cells[j]) {
                        let textValue = cells[j].textContent || cells[j].innerText;
                        if (textValue.toLowerCase().indexOf(filter) > -1) {
                            rowMatch = true;
                            break;
                        }
                    }
                }
                rows[i].style.display = rowMatch ? "" : "none";
            }

            // Hide the loading spinner after filtering
            spinner.classList.add("hidden");
        }, 500); // Adjust delay time (500ms) for smooth filtering
    }
    function previewFile(fileUrl, fileType) {
        console.log('Previewing file:', fileUrl, 'Type:', fileType);

        const modal = document.getElementById('filePreviewModal');
        const viewer = document.getElementById('fileViewer');
        const modalTitle = document.getElementById('modalTitle');

        // Set modal title
        modalTitle.textContent = "File Preview";

        // Clear previous content
        viewer.innerHTML = '';

        if (fileType.includes('image')) {
            // Display image preview
            viewer.innerHTML = `<img src="${fileUrl}" class="max-w-full h-auto rounded-lg" alt="Preview Image">`;
        } else if (fileType.includes('pdf')) {
            // Display PDF using pdf.js
            viewer.innerHTML = `<iframe src="${fileUrl}" class="w-full h-[500px]" frameborder="0"></iframe>`;
        } else if (fileType.includes('text') || fileType.includes('plain')) {
            // Fetch and display text file content
            fetch(fileUrl)
                .then(response => response.text())
                .then(text => {
                    viewer.innerHTML = `<pre class="bg-gray-800 text-white p-4 rounded-lg overflow-auto">${text}</pre>`;
                })
                .catch(error => {
                    viewer.innerHTML = `<p class="text-red-500">Error loading text file.</p>`;
                    console.error(error);
                });
        } else {
            // Unsupported file type
            viewer.innerHTML = `<p class="text-red-500">Preview not available for this file type.</p>
                <a href="${fileUrl}" class="underline text-blue-500" target="_blank">Download file instead</a>`;
        }

        // Show modal
        modal.classList.remove('hidden');
    }

    // Close Modal
    function closePreview() {
        document.getElementById('filePreviewModal').classList.add('hidden');
        document.getElementById('fileViewer').innerHTML = ''; // Clear content
    }
</script>
