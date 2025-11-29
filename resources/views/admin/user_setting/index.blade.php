<x-admin-layout title="User Settings">

<div class="p-6 bg-[#E9F6EF] min-h-screen">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- PROFILE CARD --}}
        <div class="col-span-1 space-y-6">

            <div class="bg-white p-6 rounded-2xl shadow-sm flex flex-col items-center">
                <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://i.pravatar.cc/150' }}"
                     class="w-24 h-24 rounded-full mb-3 object-cover" />

                <h2 class="text-lg font-semibold">{{ $user->first_name }} {{ $user->last_name }}</h2>
                <p class="text-gray-600">{{ $user->email }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm space-y-3">
                <h3 class="font-semibold text-gray-700">Information</h3>
                <div class="text-sm space-y-1">
                    <p><strong>Name:</strong> {{ $user->first_name }}, {{ $user->last_name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Tel:</strong> {{ $user->phone_code }} {{ $user->phone_number }}</p>
                    <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                </div>
            </div>
        </div>

        {{-- SETTINGS FORM --}}
        <div class="col-span-1 lg:col-span-2">
            <div class="bg-white p-8 rounded-3xl shadow-sm">

                <h2 class="text-xl font-semibold mb-6">User Settings</h2>

                {{-- Alerts --}}
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Profile Form --}}
                <form action="{{ route('user.settings.updateProfile') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                                   class="w-full border rounded-lg p-2 bg-gray-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                                   class="w-full border rounded-lg p-2 bg-gray-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="w-full border rounded-lg p-2 bg-gray-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Tel - Number</label>
                            <div class="flex gap-2">
                                <input type="text" name="phone_code" value="{{ old('phone_code', $user->phone_code) }}"
                                       class="w-20 border rounded-lg p-2 bg-gray-100">
                                <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                                       class="flex-1 border rounded-lg p-2 bg-gray-100">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium">Profile Photo</label>
                            <input type="file" name="profile_photo" class="w-full border rounded-lg p-2 bg-gray-100">
                        </div>
                    </div>

                    <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                        Save changes
                    </button>
                </form>

                {{-- Password Form --}}
                <h3 class="font-semibold text-gray-700 mt-10">Password</h3>
                <p class="text-sm text-gray-500 mb-4">Change password</p>

                <form action="{{ route('user.settings.updatePassword') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <input type="password" name="current_password"
                                   class="w-full border rounded-lg p-2 bg-gray-100"
                                   placeholder="Current password">
                        </div>

                        <div>
                            <input type="password" name="current_password_confirm"
                                   class="w-full border rounded-lg p-2 bg-gray-100"
                                   placeholder="Confirm current password">
                        </div>

                        <div>
                            <input type="password" name="new_password"
                                   class="w-full border rounded-lg p-2 bg-gray-100"
                                   placeholder="New password">
                        </div>

                        <div>
                            <input type="password" name="new_password_confirm"
                                   class="w-full border rounded-lg p-2 bg-gray-100"
                                   placeholder="Confirm new password">
                        </div>
                    </div>

                    <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                        Save changes
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>

</x-admin-layout>
