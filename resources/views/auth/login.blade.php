<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-slate-800">Welcome back</h1>
        <p class="text-sm text-slate-500 mt-1">Sign in to your BSMT Portal account</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-brand-700 shadow-sm focus:ring-brand-500" name="remember">
                <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-brand-700 hover:text-brand-800 underline" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center py-2.5">
                {{ __('Sign In') }}
            </x-primary-button>
        </div>

        <p class="mt-4 text-center text-sm text-slate-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-brand-700 hover:text-brand-800 font-medium underline">Register here</a>
        </p>
    </form>
</x-guest-layout>
