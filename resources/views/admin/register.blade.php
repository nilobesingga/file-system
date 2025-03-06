<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $user ? 'Edit User' : 'Register New Account' }}
        </h2>
    </x-slot> --}}

    <div class="py-3">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ $user ? route('admin.register.update', $user->id) : route('admin.register') }}" x-data="{ showPasswordModal: false }" x-cloak>
                    @csrf
                    {{-- @if($user)
                        @method('POST')
                    @endif --}}

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user ? $user->name : '')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user ? $user->email : '')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <!-- Password (Hidden by default when editing) -->
                    @if(!$user)
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password (Hidden by default when editing) -->
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    @else
                    <div class="mt-4">
                        <button type="button" @click="showPasswordModal = true" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            Update Password
                        </button>
                        <div x-show="showPasswordModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
                            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Update Password</h3>
                                <button @click="showPasswordModal = false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100 p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <div class="space-y-4">
                                    <div>
                                        <x-input-label for="password" :value="__('Password')" />
                                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" />
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="mt-4 flex justify-end space-x-4">
                                    <button type="button" @click="showPasswordModal = false" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Close
                                    </button>
                                    <x-primary-button @click="showPasswordModal = false" class="ms-0">
                                        Save
                                    </x-primary-button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Categories (Multiple Selection) -->
                    <div class="mt-4">
                        <x-input-label for="category_ids" :value="__('Categories')" />
                        <select name="category_ids[]" id="category_ids" multiple class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $user && $user->category->contains($category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_ids')" class="mt-2" />
                    </div>

                    <!-- Is Admin Toggle -->
                    <div class="mt-4">
                        <x-input-label for="is_admin" :value="__('Is Admin')" />

                        <div x-data="{ isAdmin: {{ $user && $user->is_admin ? 'true' : 'false' }} }" class="flex items-center space-x-4">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">No</span>
                            <div class="relative inline-flex items-center w-14 h-8 rounded-full cursor-pointer">
                                <input type="checkbox" id="is_admin_toggle" x-model="isAdmin" class="sr-only peer" :checked="isAdmin" @change="updateIsAdmin()">
                                <label for="is_admin_toggle" class="absolute inset-0 bg-gray-200 rounded-full peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 dark:peer-focus:ring-blue-800 transition-colors duration-200 peer-checked:bg-blue-600 peer-checked:after:translate-x-6 after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:border after:border-gray-300 after:rounded-full after:h-6 after:w-6 after:transition-transform duration-200 dark:bg-gray-700 dark:after:bg-gray-100"></label>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Yes</span>
                            <!-- Hidden input to capture is_admin value for form submission -->
                            <input type="hidden" name="is_admin" x-model="isAdmin" :value="isAdmin ? '1' : '0'">
                        </div>
                        <x-input-error :messages="$errors->get('is_admin')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            {{ $user ? 'Update' : 'Register' }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('isAdminToggle', () => ({
            isAdmin: {{ $user && $user->is_admin ? 'true' : 'false' }},
            updateIsAdmin() {
                this.$refs.is_admin.value = this.isAdmin ? '1' : '0';
            }
        }));
    });

    document.addEventListener('submit', (e) => {
        const formData = new FormData(e.target);
        console.log('Form Data:', Object.fromEntries(formData));
    }, true);
</script>
