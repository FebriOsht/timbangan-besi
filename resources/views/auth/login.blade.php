<x-auth.layout title="Login">

    <h2 class="text-2xl font-bold mb-2">Account Login</h2>

    <p class="text-gray-500 mb-6">
        If you are already a member you can login with your email address and password.
    </p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Email address</label>
            <input type="email" name="email" required
                   class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-green-200">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-green-200">
        </div>

        <div class="flex items-center mb-6">
            <input type="checkbox" name="remember" class="mr-2">
            <span class="text-gray-700">Remember me</span>
        </div>

        <button type="submit"
                class="w-full bg-green-600 text-white font-semibold py-2 rounded-md hover:bg-green-700 transition">
            Login
        </button>
    </form>

    <p class="mt-6 text-center text-gray-600">
        Don’t have an account?
        <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Sign up here</a>
    </p>

    @if (session('success'))
    <div class="p-3 mb-4 text-green-700 bg-green-100 border border-green-300 rounded">
        {{ session('success') }}
    </div>
    @endif


</x-auth.layout>
