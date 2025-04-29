<x-app-layout>
    <div class="py-3">
        <div class="w-full mx-auto sm:px-6 lg:px-20">
            <div class="overflow-hidden bg-white rounded-lg shadow-sm p-7">
                @if (session('success'))
                    <div class="mb-4 text-sm text-green-600">
                        {{ session('success') }}
                    </div>
                @endif
                <!-- Add New Users Button (Top Right) -->
                <div class="flex items-start justify-between mb-2">
                    <h3 class="mb-4 text-2xl font-semibold text-gray-900">Users</h3>
                    <a href="{{ route('admin.register') }}" class="inline-flex items-center px-5 py-1.5 leading-7 bg-customBlue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-customBlue/90 focus:bg-customBlue/90 active:bg-customBlue/90 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition ease-in-out duration-200">
                        Add New User
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Code</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Address</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Categories</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Is Admin</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $user->code }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $user->address }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                    @if($user->category->isNotEmpty())
                                        {{ $user->category->pluck('name')->implode(', ') }}
                                    @else
                                        None
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                    {{ $user->is_admin ? 'Yes' : 'No' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.register.edit') }}?edit={{ $user->id }}" class="inline-flex items-center px-3 py-1 text-sm text-white rounded-md bg-customBlue hover:bg-customBlue/90">Edit</a>
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
                <p class="mt-4 text-gray-600">No users found.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
