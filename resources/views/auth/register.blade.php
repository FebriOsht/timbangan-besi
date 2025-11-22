<x-auth.layout title="Register">

    <a href="{{ route('login') }}" class="text-sm text-gray-500 flex items-center mb-6 hover:text-gray-700">
        ← Back
    </a>

    <h2 class="text-2xl font-bold mb-2">Account Register</h2>

    <p class="text-gray-500 mb-6 text-sm">
        Please fill in the form below to create an account.
    </p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Full Name --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm mb-1">Full name</label>
            <input type="text" name="name" required
                   class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-green-200">
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm mb-1">Email address</label>
            <input type="email" name="email" required
                   class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-green-200">
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-green-200">
        </div>

        {{-- Confirm Password --}}
        <div class="mb-6">
            <label class="block text-gray-700 text-sm mb-1">Confirm password</label>
            <input type="password" name="password_confirmation" required
                   class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-green-200">
        </div>

        {{-- Terms --}}
        <div class="flex items-center mb-6">
            <input type="checkbox" name="terms" class="mr-2">
            <span class="text-gray-700 text-sm">I agree to the Terms & Conditions</span>
        </div>

        <button type="submit"
                class="w-full bg-green-600 text-white font-semibold py-2 rounded-md hover:bg-green-700 transition">
            Register
        </button>
    </form>

    <p class="mt-6 text-center text-gray-600 text-sm">
        Already have an account?
        <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Sign in here</a>
    </p>

</x-auth.layout>
