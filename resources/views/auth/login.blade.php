<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold tracking-tight text-zinc-900">Welcome back</h1>
        <p class="text-sm text-zinc-500 mt-1">Enter your credentials to access the CRM</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold text-zinc-700" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-500" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5 pt-2">
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" class="text-xs font-semibold text-zinc-700" />
                @if (Route::has('password.request'))
                    <a class="text-[11px] font-medium text-zinc-500 hover:text-zinc-900 transition-colors" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center space-x-2 pt-2">
            <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-zinc-200 text-zinc-900 focus:ring-zinc-900 shadow-sm" name="remember">
            <label for="remember_me" class="text-xs font-medium leading-none text-zinc-600">
                Remember my device
            </label>
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full h-10">
                {{ __('Secure Sign In') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
