<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Profile
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Update Profile Info --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Update Profile Information</h3>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name', $user->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                            :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="phone" :value="__('Phone Number')" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                            :value="old('phone', $user->phone)" placeholder="+1 234 567 8900" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>Save Changes</x-primary-button>
                        <a href="{{ route('profile.show') }}" class="text-gray-600 hover:underline">Cancel</a>
                    </div>
                </form>
            </div>

            {{-- Delete Account --}}
            <div class="bg-white shadow-sm rounded-lg p-6 border border-red-200">
                <h3 class="text-lg font-semibold text-red-600 mb-2">Delete Account</h3>
                <p class="text-gray-600 text-sm mb-4">
                    Once your account is deleted, all data will be permanently removed.
                    Please enter your password to confirm.
                </p>

                <form method="POST" action="{{ route('profile.destroy') }}"
                      onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.')">
                    @csrf
                    @method('DELETE')

                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Current Password')" />
                        <x-text-input id="password" name="password" type="password"
                            class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <x-danger-button>Delete My Account</x-danger-button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>