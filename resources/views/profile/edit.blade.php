<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Profile') }}
        </h2>
    </x-slot> --}}

    <div class="py-3">
        <div class="{{ Auth::check() && Auth::user()->is_admin ? 'max-w-xl' : 'max-w-xl' }} mx-auto space-y-6 sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="mb-2 font-bold">Two-Factor Authentication</h2>

                    @if (session('status') === 'two-factor-authentication-enabled')
                            <p class="mb-4 text-center text-gray-700">Please scan the QR code and confirm your setup.</p>

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
                                        class="w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm"
                                    >
                                </div>

                                <x-primary-button>{{ __('Confirm') }}</x-primary-button>
                            </form>
                    @else
                        @if (Auth::user()->two_factor_secret)
                        <form method="POST" action="/user/disable">
                                @csrf
                                @method('PUT')
                                <x-danger-button>{{ __('Disable 2FA') }}</x-danger-button>
                            </form>
                        @else
                            <form method="POST" action="/user/two-factor-authentication">
                                @csrf
                                <x-primary-button>{{ __('Enable 2FA') }}</x-primary-button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
            @if (Auth::check() && Auth::user()->is_admin)
            <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
