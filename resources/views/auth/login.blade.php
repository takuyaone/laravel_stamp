<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <h1 class="text-center mb-4 text-3xl">ログイン</h1>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="メールアドレス" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="パスワード" required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                    アカウントをお持ちでない方
                </a>

                <x-button class="ml-4">
                    ログイン
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
