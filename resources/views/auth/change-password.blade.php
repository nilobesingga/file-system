<x-guest-layout>
    <div class="mb-4 text-sm text-dark-600 dark:text-dark">
        {{ __('To continue, please change your default password.') }}
    </div>
    <form method="POST" action="{{ route('change.password') }}">
        @csrf
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full mt-1" type="email" readonly name="email" :value="old('email', $user->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Old Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Current Password')" />
            <x-text-input id="current_password" class="block w-full mt-1" type="password" name="current_password" required autocomplete="current-password" placeholder="Enter Current Password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="new-password" placeholder="Enter New Password"/>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password (Hidden by default when editing) -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" required autocomplete="confirm-password" placeholder="Confirm New Password"/>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-center mt-4">
            <x-primary-button>
                {{ __('Change Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
