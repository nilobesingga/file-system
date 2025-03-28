<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Profile') }}
        </h2>
    </x-slot> --}}

    <div class="py-3">
        <div class="{{ Auth::check() && Auth::user()->is_admin ? 'w-full' : 'max-w-7xl' }} mx-auto space-y-6 sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="mb-2 text-dark dark:text-white">Two-Factor Authentication</h2>

                    @if (session('status') === 'two-factor-authentication-enabled')
                            <p class="mb-4 text-center text-gray-700 dark:text-white">Please scan the QR code and confirm your setup.</p>

                            <div class="flex justify-center mb-6">
                                {!! Auth::user()->twoFactorQrCodeSvg() !!}
                            </div>

                            <form method="POST" action="/user/two-factor-authentication" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div>
                                    <input
                                        type="text"
                                        name="code"
                                        placeholder="Enter 2FA Code"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    >
                                </div>

                                <button
                                    type="submit"
                                    class="w-full px-4 py-2 font-semibold text-white transition duration-200 bg-blue-500 rounded-lg shadow-md hover:bg-blue-600"
                                >
                                    Confirm
                                </button>
                            </form>
                    @else
                        @if (Auth::user()->two_factor_secret)
                        <form method="POST" action="/user/disable">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="px-4 py-2 text-red-500 transition duration-200 border-2 border-red-500 rounded-lg hover:bg-red-500 hover:text-white">Disable 2FA</button>
                            </form>
                        @else
                            <form method="POST" action="/user/two-factor-authentication">
                                @csrf
                                <button type="submit" class="px-4 py-2 transition duration-200 border-2 border-blue-500 rounded-lg text-dark hover:bg-blue-500 hover:text-white dark:text-white">
                                    Enable 2FA
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
            @if (Auth::check() && Auth::user()->is_admin)
            <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
