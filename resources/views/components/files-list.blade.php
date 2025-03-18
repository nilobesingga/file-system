<div class="p-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
    <!-- Search Bar with Loading Indicator -->
    <div class="relative flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Files</h3>

        <div class="flex items-center space-x-4">
            <!-- Category Filter Dropdown -->
            <div>
                <select id="categoryFilter" onchange="filterTableByCategory()" class="px-4 py-2 text-gray-900 border rounded-md bg-gray-50 dark:bg-gray-700 dark:text-gray-100 focus:outline-none">
                    <option value="">All Categories</option>
                    @foreach($category as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Search Input -->
            <div class="relative">
                <input type="text" id="searchInput" onkeyup="searchTable()"
                       placeholder="Search files..."
                       class="px-4 py-2 text-gray-900 border rounded-md bg-gray-50 dark:bg-gray-700 dark:text-gray-100">

                <!-- Loading Spinner -->
                <div id="loadingSpinner" class="absolute hidden transform -translate-y-1/2 right-3 top-1/2">
                    <svg class="w-5 h-5 text-blue-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0116 0"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Uploaded Files Table -->
    <div class="overflow-x-auto">
        <table id="filesTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Document Name</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Category</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Upload Date</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @foreach($files as $file)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap dark:text-gray-900">{{ $file->document_name ?? $file->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap dark:text-gray-100" data-category-id="{{ $file->category ? $file->category->id : '' }}">
                        {{ $file->category ? $file->category->name : 'Uncategorized' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap dark:text-gray-300">{{ $file->created_at->format('F d, Y h:i A') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap dark:text-gray-300">
                        <div class="flex space-x-2">
                            <!-- Preview Button -->
                            <button onclick="previewFile('{{ asset('storage/' . $file->path) }}', '{{ Storage::mimeType($file->path) }}')"
                                class="inline-flex items-center px-3 py-1 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                Preview
                            </button>
                            <!-- Download Button -->
                            <a href="{{ route('file.download', $file) }}" class="inline-flex items-center px-3 py-1 text-sm text-white bg-green-600 rounded-md hover:bg-green-700">
                                Download
                            </a>
                            @if(Auth::check() && Auth::user()->is_admin && Route::currentRouteName() !== 'dashboard')
                                <form action="{{ route('file.destroy', $file->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1 text-sm text-white bg-red-600 rounded-md hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this file?')">
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
        {{ $files->links() }} <!-- Laravel Pagination -->
    </div>
    <!-- No Files Message -->
    @if($files->isEmpty())
    <p class="mt-4 text-gray-600 dark:text-gray-300">No files uploaded yet.</p>
    @endif
</div>

<!-- File Preview Modal -->
<div id="filePreviewModal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-600 bg-opacity-50">
    <div class="relative w-3/4 max-w-4xl p-6 overflow-auto bg-white rounded-lg shadow-lg dark:bg-gray-800">
        <h3 id="modalTitle" class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">File Preview</h3>
        <button onclick="closePreview()" class="absolute p-2 text-gray-500 rounded-full top-4 right-4 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div id="fileViewer" class="w-full h-[500px] overflow-auto"></div>
        <div class="flex justify-end mt-4">
            <button onclick="closePreview()" class="inline-flex items-center px-4 py-2 text-gray-800 transition-all duration-200 bg-gray-200 rounded-md dark:bg-gray-600 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Close
            </button>
        </div>
    </div>
</div>

<!-- JavaScript for Search, Category Filter, and Preview -->
<script>
    let searchTimeout;

    function searchTable() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let categoryFilter = document.getElementById("categoryFilter").value; // Get selected category ID
        let table = document.getElementById("filesTable");
        let rows = table.getElementsByTagName("tr");
        let spinner = document.getElementById("loadingSpinner");

        // Show the loading spinner
        spinner.classList.remove("hidden");

        // Clear the previous timeout (debouncing)
        clearTimeout(searchTimeout);

        // Delay the execution of filtering for a smooth experience
        searchTimeout = setTimeout(() => {
            for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header row
                let cells = rows[i].getElementsByTagName("td");
                let fileName = cells[0]?.textContent.toLowerCase() || ''; // Document Name
                let categoryId = cells[1]?.dataset.categoryId || ''; // Category ID from data attribute

                // Match search input
                let matchesSearch = fileName.includes(input);

                // Match category filter
                let matchesCategory = categoryFilter === '' || categoryId === categoryFilter;

                // Show/hide row based on both filters
                if (matchesSearch && matchesCategory) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }

            // Hide the loading spinner after filtering
            spinner.classList.add("hidden");
        }, 500); // Adjust delay time (500ms) for smooth filtering
    }

    // Filter table by category when the dropdown changes
    function filterTableByCategory() {
        searchTable(); // Re-run the searchTable function with the new category filter
    }

    function previewFile(fileUrl, fileType) {
        console.log('Previewing file:', fileUrl, 'Type:', fileType);

        const modal = document.getElementById('filePreviewModal');
        const viewer = document.getElementById('fileViewer');
        const modalTitle = document.getElementById('modalTitle');

        modalTitle.textContent = "File Preview";

        viewer.innerHTML = '';

        if (fileType.includes('image')) {
            viewer.innerHTML = `<img src="${fileUrl}" class="h-auto max-w-full rounded-lg" alt="Preview Image">`;
        } else if (fileType.includes('pdf')) {
            viewer.innerHTML = `<iframe src="${fileUrl}" class="w-full h-[500px]" frameborder="0"></iframe>`;
        } else if (fileType.includes('text') || fileType.includes('plain')) {
            fetch(fileUrl)
                .then(response => response.text())
                .then(text => {
                    viewer.innerHTML = `<pre class="p-4 overflow-auto text-white bg-gray-800 rounded-lg">${text}</pre>`;
                })
                .catch(error => {
                    viewer.innerHTML = `<p class="text-red-500">Error loading text file.</p>`;
                    console.error(error);
                });
        } else {
            viewer.innerHTML = `<p class="text-red-500">Preview not available for this file type.</p>
                <a href="${fileUrl}" class="text-blue-500 underline" target="_blank">Download file instead</a>`;
        }

        modal.classList.remove('hidden');
    }

    // Close Modal
    function closePreview() {
        document.getElementById('filePreviewModal').classList.add('hidden');
        document.getElementById('fileViewer').innerHTML = '';
    }
</script>
