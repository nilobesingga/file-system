<!-- resources/views/components/upload-file-modal.blade.php -->
<div x-data="{ open: false }" x-show="open" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center" @keydown.escape.window="open = false" x-cloak>
    <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
        <!-- Modal Header -->
        <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-4 mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Upload New File</h3>
            <button @click="open = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100 p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Upload Form -->
        <form action="{{ route('admin.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4" @submit.prevent="submitForm">
            @csrf
            <div>
                <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select PDF File</label>
                <input type="file" name="file" id="file" accept=".pdf" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" required>
                @error('file')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" @click="open = false" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                    Cancel
                </button>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('uploadModal', () => ({
            open: false,
            submitForm() {
                this.$refs.form.submit(); // Submit the form
            }
        }));
    });
</script>
