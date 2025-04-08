<x-app-layout>
    <div class="py-3">
        <div class="w-full mx-auto sm:px-6 lg:px-20">
            @if (session('success'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Category Creation Form -->
            <div class="mb-4 rounded-lg shadow p-7 bg-gray-50">
                <h3 class="mb-4 text-2xl font-semibold text-gray-900">Create New Category</h3>
                <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="name" :value="__('Category Name')" />
                        <x-text-input id="name" class="block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" name="name" required />
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" class="block w-full mt-1 text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring-sky-500"></textarea>
                    </div>
                    <x-primary-button>
                        {{ __('Create Category') }}
                    </x-primary-button>
                </form>
            </div>

            <!-- Existing Categories Table -->
            <div class="mt-6">
                <div class="bg-white rounded-lg shadow p-7">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">Existing Categories</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Name</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Description</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($categories as $category)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $category->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">{{ $category->description ?? 'No description' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}')" class="inline-flex items-center px-3 py-1 text-sm text-white rounded-md bg-customBlue hover:bg-customBlue/90">Edit</button>
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 text-sm text-white rounded-md bg-rose-600 hover:bg-rose-700" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
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
        </div>
    </div>
    <div id="editCategoryModal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-600 bg-opacity-50">
        <div class="w-1/3 p-6 bg-white rounded shadow-md">
            <h2 class="mb-4 text-xl font-bold">Edit Category</h2>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editCategoryId" name="id">

                <div class="mb-4">
                    <x-input-label for="editName" :value="__('Category Name')" />
                    <x-text-input id="editName" class="block w-full mt-1 text-sm text-gray-900 border border-gray-400 cursor-pointer focus:outline-none" name="name" required />
                </div>

                <div class="mb-4">
                    <label for="editDescription" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="editDescription" class="block w-full mt-1 text-sm text-gray-900 border border-gray-400 cursor-pointer focus:outline-none focus:border-caplionGold focus:ring-caplionGold"></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeEditModal()" class="inline-flex items-center px-3 py-1 text-sm font-medium text-white transition-all duration-200 rounded-md bg-rose-600 hover:bg-red-700 hover:border-red-500 hover:text-white">CANCEL</button>
                    <x-primary-button>
                        {{ __('Update') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
<script>
    function editCategory(id, name, description) {
        document.getElementById('editCategoryId').value = id;
        document.getElementById('editName').value = name;
        document.getElementById('editDescription').value = description;
        let updateRoute = `{{ route('categories.update', 'id') }}`.replace('id', id);
        document.getElementById('editCategoryForm').action = updateRoute;
        document.getElementById('editCategoryModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editCategoryModal').classList.add('hidden');
    }
</script>
