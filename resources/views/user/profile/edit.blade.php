<x-app-layout>
    <section class="pt-4 mr-7">

        <div class="">
            <div class="flex items-center justify-between ">
                <div class="">
                    <h1 class="text-xl mb-2">{{ ucfirst(auth()->user()->office) }} Dashboard</h1>
                    <h1 class="text-gray-500 italic">Document Tracking and Storage System</h1>
                </div>
                <div class="text-right">
                <div class="">
                        <p id="current-date"></p>
                        <p id="current-time"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-2 bg-white rounded-lg shadow-lg px-5 py-2 w-full">
            <div class="w-full my-5">
                <div class="">
                    <h1 class="text-2xl font-bold mb-4">Edit Profile</h1>

                    @if (session('success'))
                        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('user.profile.update') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 rounded-md p-2">
                            @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-300 rounded-md p-2">
                            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="current_password" class="block text-gray-700">Current Password</label>
                            <input type="password" id="current_password" name="current_password" class="w-full border border-gray-300 rounded-md p-2">
                            @error('current_password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-gray-700">New Password (Optional)</label>
                            <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-md p-2">
                            @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-gray-700">Confirm New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full border border-gray-300 rounded-md p-2">
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>

<script>
        function updateDateTime() {
            const dateElement = document.getElementById('current-date');
            const timeElement = document.getElementById('current-time');

            if (dateElement && timeElement) {
                const now = new Date();

                // Format the date
                const formattedDate = now.toLocaleDateString('en-US', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                });

                // Format the time
                const formattedTime = now.toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: 'numeric',
                    second: 'numeric',
                    hour12: true,
                });

                // Update the elements
                dateElement.textContent = formattedDate;
                timeElement.textContent = formattedTime;
            }
        }

        // Update the date and time every second
        setInterval(updateDateTime, 1000);

        // Initialize the date and time on page load
        updateDateTime();
    </script>