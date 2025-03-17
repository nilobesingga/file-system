<x-app-layout>
    <div class="py-3">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                @if (session('success'))
                    <div class="mb-4 text-sm text-green-600 dark:text-green-400">
                        {{ session('success') }}
                    </div>
                @endif
                    <!-- Add New Users Button (Top Right) -->
                <div class="flex justify-end mb-4">
                    <a href="{{ route('admin.register') }}" class="inline-flex items-center px-4 py-2 text-white transition-all duration-200 bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Add New User
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Name</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Email</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Categories</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Is Admin</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach($users as $user)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap dark:text-gray-100">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap dark:text-gray-300">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap dark:text-gray-300">
                                    @if($user->category->isNotEmpty())
                                        {{ $user->category->pluck('name')->implode(', ') }}
                                    @else
                                        None
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap dark:text-gray-300">
                                    {{ $user->is_admin ? 'Yes' : 'No' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap dark:text-gray-300">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.register.edit') }}?edit={{ $user->id }}" class="inline-flex items-center px-3 py-1 text-sm text-white bg-yellow-600 rounded-md hover:bg-yellow-700">Edit</a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 text-sm text-white bg-red-600 rounded-md hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- No Users Message -->
                @if($users->isEmpty())
                <p class="mt-4 text-gray-600 dark:text-gray-300">No users found.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
