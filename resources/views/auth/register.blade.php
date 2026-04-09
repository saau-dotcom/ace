<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold tracking-tight text-zinc-900">Create an account</h1>
        <p class="text-sm text-zinc-500 mt-1">Enter your details to register for the CRM</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div class="space-y-1.5">
            <x-input-label for="name" :value="__('Name')" class="text-xs font-semibold text-zinc-700" />
            <x-text-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-red-500" />
        </div>

        <!-- Email Address -->
        <div class="space-y-1.5 pt-2">
            <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold text-zinc-700" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-500" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5 pt-2">
            <x-input-label for="password" :value="__('Password')" class="text-xs font-semibold text-zinc-700" />

            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1.5 pt-2">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-xs font-semibold text-zinc-700" />

            <x-text-input id="password_confirmation" class="block w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-red-500" />
        </div>

        <div class="pt-6">
            <x-primary-button class="w-full h-10">
                {{ __('Create Account') }}
            </x-primary-button>
        </div>
        
        <div class="text-center mt-4">
            <a class="text-[11px] font-medium text-zinc-500 hover:text-zinc-900 transition-colors" href="{{ route('login') }}">
                {{ __('Already have an account? Sign in') }}
            </a>
        </div>
    </form>
</x-guest-layout>
