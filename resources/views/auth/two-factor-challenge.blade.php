<x-guest-layout>
        <h2 class="mb-4 text-xl font-bold text-gray-800">Two-Factor Authentication</h2>
        <p class="mb-4 text-gray-700">Please enter the code from your authenticator app.</p>

        <form method="POST" action="{{ route('two-factor.verify') }}" class="space-y-4">
            @csrf
            <div>
                <input
                    type="text"
                    name="code"
                    placeholder="Enter 2FA Code"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('code')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <button
                type="submit"
                class="w-full px-4 py-2 font-semibold text-white transition duration-200 bg-blue-500 rounded-lg shadow-md hover:bg-blue-600"
            >
                Verify
            </button>
        </form>
</x-guest-layout>
