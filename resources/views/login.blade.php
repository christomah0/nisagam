<x-layouts.app-layout>
    <main class="min-h-screen flex items-center">
        <x-card class="w-full" maxWidth="md">
            <div class="text-center mb-6">
                <img src="/favicon.svg" alt="Logo" class="mx-auto mb-2" width="100" height="100">
                <h2 class="text-xl font-bold mb-1">NISAGAM</h2>
                <p class="text-gray-600">Connectez-vous à votre compte</p>
            </div>

            <form method="POST" action="/login">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
                    <input type="email" placeholder="name@example.com" name="email" id="email"
                        class="w-full border border-gray-200 p-2 rounded-md" value="{{ old('email') }}" required
                        autofocus>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <div class="flex justify-between">
                        <label for="password" class="block text-gray-700 font-bold mb-2">Mot de passe:</label>
                        <a href="/forgot-password" class="text-sm text-gray-700 underline mt-2 inline-block">Mot de
                            passe oublié?</a>
                    </div>
                    <input type="password" name="password" placeholder="votre mot de passe" id="password"
                        class="w-full border border-gray-200 p-2 rounded-md" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Remember Me -->
                    <div class="form-control mt-4">
                        <label class="label cursor-pointer flex justify-start items-center">
                            <input type="checkbox" name="remember" class="checkbox checked:bg-amber-500">
                            <span class="text-sm text-gray-700 ml-2">Souviens-toi de moi</span>
                        </label>
                    </div>
                </div>

                <button type="submit"
                    class="bg-amber-500 w-full text-gray-700 font-bold py-2 px-4 rounded-md hover:bg-amber-600 cursor-pointer">Se
                    connecter</button>
            </form>
        </x-card>
    </main>
</x-layouts.app-layout>