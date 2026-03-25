<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Profile
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4">{{ $user->name }}</h3>
                <p class="text-gray-600"><strong>Email:</strong> {{ $user->email }}</p>
                <p class="text-gray-600 mt-2"><strong>Phone:</strong> {{ $user->phone ?? 'Not provided' }}</p>
                <p class="text-gray-600 mt-2"><strong>Member since:</strong> {{ $user->created_at->format('M d, Y') }}</p>

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('profile.edit') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
