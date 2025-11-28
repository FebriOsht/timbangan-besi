<x-admin-layout title="User Settings">

<div class="p-6 bg-[#E9F6EF] min-h-screen">

    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ======================= --}}
        {{--      PROFILE CARD       --}}
        {{-- ======================= --}}
        <div class="col-span-1 space-y-6">

            {{-- Profile --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm flex flex-col items-center">
                <img src="https://i.pravatar.cc/150"
                     class="w-24 h-24 rounded-full mb-3 object-cover" />

                <h2 class="text-lg font-semibold">@User-Name</h2>
                <p class="text-gray-600">user@email.com</p>
            </div>

            {{-- Info Box --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm space-y-3">

                <h3 class="font-semibold text-gray-700">Information</h3>

                <div class="text-sm space-y-1">
                    <p><strong>Name:</strong> Nama, Last Name</p>
                    <p><strong>Email:</strong> user@email.com</p>
                    <p><strong>Tel:</strong> +51 966 696 123</p>
                    <p><strong>Role:</strong> Admin</p>
                </div>

                <h3 class="font-semibold text-gray-700 pt-4">Preferences</h3>
                <p><strong>Role:</strong> Admin</p>

                {{-- Light / Dark Toggle --}}
                <div class="flex items-center gap-2">
                    <span class="text-sm">Light/dark:</span>

                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-10 h-5 bg-gray-300 rounded-full peer peer-checked:bg-green-500 
                                    relative transition-all duration-200">
                            <div class="absolute w-4 h-4 bg-white rounded-full top-0.5 left-0.5
                                        transition-all peer-checked:left-5"></div>
                        </div>
                    </label>
                </div>

            </div>
        </div>


        {{-- ======================= --}}
        {{--     SETTINGS FORM       --}}
        {{-- ======================= --}}
        <div class="col-span-1 lg:col-span-2">
            <div class="bg-white p-8 rounded-3xl shadow-sm">

                <h2 class="text-xl font-semibold mb-6">User Settings</h2>

                {{-- Details --}}
                <h3 class="font-semibold text-gray-700 mb-2">Details</h3>

                <form action="#" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label class="block text-sm font-medium">Name</label>
                            <input type="text"
                                   class="w-full border rounded-lg p-2 bg-gray-100"
                                   placeholder="Your first name">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Last Name</label>
                            <input type="text"
                                   class="w-full border rounded-lg p-2 bg-gray-100"
                                   placeholder="Your last name">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Email</label>
                            <input type="email"
                                   class="w-full border rounded-lg p-2 bg-gray-100"
                                   placeholder="email@example.com">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Tel - Number</label>
                            <div class="flex gap-2">
                                <input type="text"
                                       class="w-20 border rounded-lg p-2 bg-gray-100"
                                       placeholder="+51">

                                <input type="text"
                                       class="flex-1 border rounded-lg p-2 bg-gray-100"
                                       placeholder="969 123 456">
                            </div>
                        </div>

                    </div>

                    <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                        Save changes
                    </button>

                </form>



                {{-- ======================= --}}
                {{--     PASSWORD FORM       --}}
                {{-- ======================= --}}

                <h3 class="font-semibold text-gray-700 mt-10">Password</h3>
                <p class="text-sm text-gray-500 mb-4">Change password</p>

                <form action="#" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <input type="password"
                                   class="w-full border rounded-lg p-2 bg-gray-100"
                                   placeholder="Put your password...">
                        </div>

                        <div>
                            <input type="password"
                                   class="w-full border rounded-lg p-2 bg-gray-100"
                                   placeholder="Confirm password...">
                        </div>

                        <div>
                            <input type="password"
                                   class="w-full border rounded-lg p-2 bg-gray-100"
                                   placeholder="Put your new password...">
                        </div>

                        <div>
                            <input type="password"
                                   class="w-full border rounded-lg p-2 bg-gray-100"
                                   placeholder="Confirm new password...">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                            Save changes
                        </button>

                        <a href="#" class="text-sm text-gray-600 underline">
                            Forgot your password?
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

</x-admin-layout>
