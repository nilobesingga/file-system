<div class="py-6 overflow-hidden bg-white shadow-sm px-7 sm:rounded-lg">
    <!-- Search Bar with Loading Indicator -->
    <div class="relative flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-gray-900">Files</h3>

        <div class="flex items-center space-x-4">
            <!-- Category Filter Dropdown -->
            <div>
                <select id="categoryFilter" onchange="filterTableByCategory()" class="px-4 py-2 text-gray-700 border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring-sky-500">
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
                       class="px-4 py-2 text-gray-700 border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring-sky-500">

                <!-- Loading Spinner -->
                <div id="loadingSpinner" class="absolute hidden transform -translate-y-1/2 right-3 top-1/2">
                    <svg class="w-5 h-5 text-sky-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0116 0"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Uploaded Files Table -->
    <div class="overflow-x-auto">
        <table id="filesTable" class="min-w-full divide-y divide-gray-300">
            <thead>
                <tr>
                    <th scope="col" class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer text-nowrap">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'unread', 'direction' => request('sort') === 'unread' && request('direction') === 'desc' ? 'asc' : 'desc']) }}" aria-label="Sort by Read/Unread status">
                            Read / Unread
                            <span class="ml-2 sort-icon" data-column="0">
                                @if(request('sort') === 'unread')
                                    @if(request('direction') === 'asc')
                                        <svg class="inline-block w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="inline-block w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @else
                                    <svg class="inline-block w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer text-nowrap {{ (!Auth::user()->is_admin) ? 'hidden' : '' }}">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'statement_no', 'direction' => request('sort') === 'statement_no' && request('direction') === 'desc' ? 'asc' : 'desc']) }}" aria-label="Sort by Statement Number">
                            Investor Name
                            <x-sort-icon column="statement_no" />
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer text-nowrap ">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'document_name', 'direction' => request('sort') === 'document_name' && request('direction') === 'desc' ? 'asc' : 'desc']) }}" aria-label="Sort by Document Name">
                            Bond Name
                            <span class="ml-2 sort-icon" data-column="1">
                                @if(request('sort') === 'document_name')
                                    @if(request('direction') === 'asc')
                                        <svg class="inline-block w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="inline-block w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @else
                                    <svg class="inline-block w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer text-nowrap">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'statement_no', 'direction' => request('sort') === 'statement_no' && request('direction') === 'desc' ? 'asc' : 'desc']) }}" aria-label="Sort by Statement Number">
                            Statement #
                            <x-sort-icon column="statement_no" />
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer text-nowrap">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'statement_period', 'direction' => request('sort') === 'statement_period' && request('direction') === 'desc' ? 'asc' : 'desc']) }}" aria-label="Sort by Statement Period">
                            Statement Period
                            <x-sort-icon column="statement_period" />
                        </a>
                    </th>
                    {{-- <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer text-nowrap">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'number_of_bonds', 'direction' => request('sort') === 'number_of_bonds' && request('direction') === 'desc' ? 'asc' : 'desc']) }}" aria-label="Sort by Number of Bonds">
                            No. of Bonds
                            <x-sort-icon column="number_of_bonds" />
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer text-nowrap">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'amount_subscribed', 'direction' => request('sort') === 'amount_subscribed' && request('direction') === 'desc' ? 'asc' : 'desc']) }}" aria-label="Sort by Amount">
                            Amount
                            <x-sort-icon column="amount_subscribed" />
                        </a>
                    </th> --}}
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer text-nowrap">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'category', 'direction' => request('sort') === 'category' && request('direction') === 'desc' ? 'asc' : 'desc']) }}" aria-label="Sort by Category">
                            Category
                            <span class="ml-2 sort-icon" data-column="2">
                                @if(request('sort') === 'category')
                                    @if(request('direction') === 'asc')
                                        <svg class="inline-block w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="inline-block w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @else
                                    <svg class="inline-block w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer text-nowrap">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('sort') === 'created_at' && request('direction') === 'desc' ? 'asc' : 'desc']) }}" aria-label="Sort by Upload Date">
                            Upload Date
                            <span class="ml-2 sort-icon" data-column="3">
                                @if(request('sort') === 'created_at')
                                    @if(request('direction') === 'asc')
                                        <svg class="inline-block w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="inline-block w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @else
                                    <svg class="inline-block w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($files as $file)
                <tr class="{{ $file->isReadByCurrentUser() ? '' : 'bg-sky-100/50' }} hover:bg-gray-50" onclick="toggleReadStatus({{ $file->id }})" style="cursor: pointer;">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <!-- Hidden Checkbox (for sorting purposes) -->
                            <input type="checkbox"
                                   class="hidden toggle-read"
                                   data-file-id="{{ $file->id }}"
                                   {{ !$file->isReadByCurrentUser() ? '' : 'checked' }}
                                   onchange="toggleReadStatus({{ $file->id }})">
                            <!-- Font Awesome Envelope Icon -->
                            <span class="read-icon" data-file-id="{{ $file->id }}" aria-label="{{ $file->isReadByCurrentUser() ? 'File read' : 'File unread' }}">
                                @if($file->isReadByCurrentUser())
                                    <!-- Open Envelope (Read) -->
                                    <i class="text-gray-500 fas fa-envelope-open"></i>
                                @else
                                    <!-- Closed Envelope (Unread) -->
                                    <i class="text-gray-800 fas fa-envelope"></i>
                                @endif
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap {{ (!Auth::user()->is_admin) ? 'hidden' : '' }}">{{ $file->user->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $file->document_name ?? $file->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $file->statement_no }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $file->statement_period ? \Carbon\Carbon::parse($file->statement_period)->format('M Y') : '-' }}</td>
                    {{-- <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ number_format($file->number_of_bonds) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $file->currency }} {{ number_format($file->amount_subscribed, 2) }}</td> --}}
                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap" data-category-id="{{ $file->category ? $file->category->id : '' }}">
                        {{ $file->category ? $file->category->name : 'Uncategorized' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap" data-upload-date="{{ $file->created_at->format('Y-m-d H:i:s') }}">
                        {{ $file->created_at->format('F d, Y h:i A') }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                        <div class="flex space-x-2">
                            <!-- Preview Button -->
                            <button onclick="event.stopPropagation(); previewFile('{{ asset('storage/' . $file->path) }}', '{{ Storage::mimeType($file->path) }}', {{ $file->id }})"
                                    class="inline-flex items-center px-3 py-1.5 text-sm text-white rounded-md bg-customBlue hover:bg-customBlue/90 transition-all duration-200">
                                Preview
                            </button>
                            <!-- Download Button -->
                            <a href="{{ route('file.download', $file) }}"
                               onclick="event.stopPropagation(); markAsRead({{ $file->id }})"
                               class="inline-flex items-center px-3 py-1.5 text-sm text-white rounded-md bg-customGreen hover:bg-customGreen/90 transition-all duration-200">
                                Download
                            </a>
                            @if(Auth::check() && Auth::user()->is_admin && Route::currentRouteName() !== 'dashboard')
                                <form action="{{ route('file.destroy', $file->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1 text-sm text-white bg-red-600 rounded-md hover:bg-red-700" onclick="event.stopPropagation(); return confirm('Are you sure you want to delete this file?')">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center py-52">
                                <!-- SVG Icon for Empty State -->
                                <svg class="w-16 h-16 mb-2 text-gray-300 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-sm text-gray-400 ">No files found.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $files->links() }} <!-- Laravel Pagination -->
    </div>
</div>

<!-- File Preview Modal -->
<div id="filePreviewModal" class="fixed inset-0 flex items-center justify-center hidden bg-sky-950/90 backdrop-blur-sm">
    <div class="relative w-3/4 max-w-4xl p-8 overflow-auto bg-white rounded-lg shadow-lg">
        <h3 id="modalTitle" class="mb-4 text-2xl font-semibold text-gray-900">File Preview</h3>
        <button onclick="closePreview()" class="absolute p-2 text-gray-500 rounded-full top-4 right-4 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div id="fileViewer" class="w-full h-[500px] overflow-auto"></div>
    </div>
</div>

<!-- JavaScript for Search, Category Filter, and Preview -->
<script>
    let searchTimeout;

    function searchTable() {
        return new Promise((resolve) => {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let categoryFilter = document.getElementById("categoryFilter").value;
            let table = document.getElementById("filesTable");
            let spinner = document.getElementById("loadingSpinner");

            spinner.classList.remove("hidden");

            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(() => {
                let isAdmin = {{ Auth::check() && Auth::user()->is_admin ? 'true' : 'false' }};
                let fileNameIndex = isAdmin ? 0 : 1;
                let categoryIndex = isAdmin ? 1 : 6;

                // Fetch the current rows from the DOM
                let rows = Array.from(table.getElementsByTagName("tr")).slice(1);
                let visibleRows = 0;

                rows.forEach(row => {
                    let cells = row.getElementsByTagName("td");
                    let fileName = cells[fileNameIndex]?.textContent.toLowerCase() || '';
                    let categoryId = cells[categoryIndex]?.dataset.categoryId || '';

                    let matchesSearch = fileName.includes(input);
                    let matchesCategory = categoryFilter === '' || categoryId === categoryFilter;

                    if (matchesSearch && matchesCategory) {
                        row.style.display = '';
                        visibleRows++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Remove existing "No files found" row if present
                let noFilesRow = document.getElementById("noFilesRow");
                if (noFilesRow) {
                    noFilesRow.remove();
                }

                // If no rows are visible, show the "No files found" message
                if (visibleRows === 0) {
                    let noFilesRow = document.createElement("tr");
                    noFilesRow.id = "noFilesRow";
                    noFilesRow.innerHTML = `
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center py-8">
                                <!-- SVG Icon for Empty State -->
                                <svg class="w-16 h-16 mb-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-sm text-red-400">No files found.</p>
                            </div>
                        </td>
                    `;
                    table.querySelector("tbody").appendChild(noFilesRow);
                }

                spinner.classList.add("hidden");
                resolve();
            }, 500);
        });
    }

    function filterTableByCategory() {
        searchTable();
    }

    function previewFile(fileUrl, fileType, fileId) {
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

        markAsRead(fileId);

        modal.classList.remove('hidden');
    }

    function closePreview() {
        document.getElementById('filePreviewModal').classList.add('hidden');
        document.getElementById('fileViewer').innerHTML = '';
    }

    function toggleReadStatus(fileId) {
        console.log('Toggling read status for fileId:', fileId);
        const checkbox = document.querySelector(`input[data-file-id="${fileId}"]`);
        if (!checkbox) {
            console.error(`Checkbox for fileId ${fileId} not found`);
            return;
        }
        checkbox.checked = !checkbox.checked;

        fetch(`/files/${fileId}/toggle-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ read: checkbox.checked })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = checkbox.closest('tr');
                if (row) {
                    row.classList.toggle('bg-sky-50', !data.read);
                } else {
                    console.error(`Row for fileId ${fileId} not found`);
                }

                const iconSpan = document.querySelector(`span.read-icon[data-file-id="${fileId}"]`);
                if (iconSpan) {
                    iconSpan.innerHTML = data.read
                        ? `<i class="text-gray-500 fas fa-envelope-open"></i>`
                        : `<i class="text-gray-800 fas fa-envelope"></i>`;
                    iconSpan.setAttribute('aria-label', data.read ? 'File read' : 'File unread');
                } else {
                    console.error(`Icon span for fileId ${fileId} not found`);
                }
            } else {
                checkbox.checked = !checkbox.checked;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            checkbox.checked = !checkbox.checked;
        });
    }

    function markAsRead(fileId) {
        console.log('Marking as read for fileId:', fileId);
        fetch(`/files/${fileId}/toggle-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ read: true })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const checkbox = document.querySelector(`input[data-file-id="${fileId}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                    const row = checkbox.closest('tr');
                    if (row) {
                        row.classList.remove('bg-sky-50');
                    } else {
                        console.error(`Row for fileId ${fileId} not found`);
                    }

                    const iconSpan = document.querySelector(`span.read-icon[data-file-id="${fileId}"]`);
                    if (iconSpan) {
                        iconSpan.innerHTML = `<i class="text-gray-500 fas fa-envelope-open"></i>`;
                        iconSpan.setAttribute('aria-label', 'File read');
                    } else {
                        console.error(`Icon span for fileId ${fileId} not found`);
                    }
                } else {
                    console.error(`Checkbox for fileId ${fileId} not found`);
                }
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
