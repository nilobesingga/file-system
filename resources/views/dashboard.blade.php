<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            User Dashboard
        </h2>
    </x-slot> --}}

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- User Profile Section -->
            <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Welcome, {{ Auth::user()->name }}!</h3>
                <p class="text-gray-600 dark:text-gray-300 mt-2">
                    Email: {{ Auth::user()->email }}<br>
                    Member Since: {{ Auth::user()->created_at->format('F d, Y') }}
                </p>
            </div>

            <x-user-file-system-widget
                    :totalFiles="0"
                    :storageUsage="0"
                    :recentUploadsCount="0"
            />
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Uploaded Files Table -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Your Files</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">File Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Upload Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Size</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($files as $file)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $file->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $file->created_at->format('F d, Y h:i A') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">0 KB</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        <div class="flex space-x-2">
                                            <!-- Preview Button (PDFs only) -->
                                            @if(str_ends_with($file->path, '.pdf'))
                                                <button onclick="previewPDF('{{ Storage::url($file->path) }}')" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                                                    Preview
                                                </button>
                                            @endif
                                            <!-- Download Button -->
                                            <a href="{{ Storage::url($file->path) }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                                                Download
                                            </a>
                                            <!-- Delete Button (Optional - requires DELETE route) -->
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
</x-app-layout>
