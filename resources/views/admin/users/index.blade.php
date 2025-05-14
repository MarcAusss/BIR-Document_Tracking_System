<x-admin-app-layout>
    <section class="pt-4 mr-7">

        <div class="">
            <div class="flex items-center justify-between ">
                <div class="">
                    <h1 class="text-xl mb-2">Regional Director Dashboard</h1>
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

        <div class="flex gap-5">
            <div class="w-full">
                <div class="bg-white mt-2 rounded-lg shadow-lg p-5">
                    <h1 class="text-2xl font-bold mb-4">Users List</h1>
                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-[#102566] text-white text-left">
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Office</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2">{{ $user->name }}</td>
                                    <td class="px-4 py-2">{{ $user->email }}</td>
                                    <td class="px-4 py-2">{{ $user->office ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

</x-admin-app-layout>

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