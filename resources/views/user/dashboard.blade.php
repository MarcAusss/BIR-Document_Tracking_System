<x-app-layout>
    <section class="pt-4 mr-7">
        <div class="">
            <div class="flex items-center justify-between ">
                <div class="">
                    <h1 class="text-xl mb-2">{{ ucfirst(auth()->user()->office) }} Dashboard</h1>
                    <h1 class="text-gray-500 italic">Document Tracking and Storage System</h1>
                </div>
                <div class="text-right">
                    <div class="text-right">
                        <div class="">
                            <p id="current-date"></p>
                            <p id="current-time"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex gap-5">
            <div class="w-full">
                <div class="mt-2">
                    <div class="flex gap-5 my-4">
                        <div class="flex gap-4 border-r-2 border-gray-300 items-center justify-center w-full py-3 bg-white rounded-lg shadow-lg">
                            <img src="{{ url('img/document.png')}}" alt="" class="w-[40px]">
                            <div class="">
                                <h1 class="text-center text-md font-bold text-gray-800">
                                    Document
                                </h1>
                                <h1 class="text-3xl text-gray-800">
                                    {{ $documentCount }}
                                </h1>
                            </div>
                        </div>
                        <div class="flex gap-4 border-r-2 border-gray-300 items-center justify-center w-full py-3 bg-white rounded-lg shadow-lg">
                            <img src="{{ url('img/notification.png')}}" alt="" class="w-[40px]">
                            <div class="">
                                <h1 class="text-center text-md font-bold text-gray-800">
                                    Notifications
                                </h1>
                                <h1 class="text-3xl text-gray-800">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </h1>
                            </div>
                        </div>
                        <div class="flex gap-4 items-center justify-center w-full py-3 bg-white rounded-lg shadow-lg">
                            <img src="{{ url('img/file.png')}}" alt="" class="w-[40px]">
                            <div class="">
                                <h1 class="text-center text-md font-bold text-gray-800">
                                    Document
                                </h1>
                                <h1 class="text-3xl text-gray-800">
                                    0
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2 bg-white rounded-lg shadow-lg px-5 py-2 w-full">
                    <div class="">
                        <table id="documentTable" class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="px-4 py-2 w-[50px]">#</th>
                                    <th class="px-4 py-2">Document Type</th>
                                    <th class="px-4 py-2">Taxpayer Name</th>
                                    <th class="px-4 py-2">Docket Owner</th>
                                    <th class="px-4 py-2">Taxable Period/Year</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($documents as $index => $document)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2">{{ $document->document_type }}</td>
                                        <td class="px-4 py-2">{{ $document->taxpayer_name }}</td>
                                        <td class="px-4 py-2">{{ $document->docket_owner }}</td>
                                        <td class="px-4 py-2">{{ $document->taxable_period }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-500 py-4">No documents found for your office.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            <div class="w-[450px] bg-white h-[87vh] mt-2 rounded-lg shadow-lg overflow-y-auto">
                <h1 class="text-xl text-center pb-5 mx-5 border-b-2 border-black p-5">Notifications</h1>
                <div class="overflow-y-auto h-[75vh] w-full px-2" id="notifications-container">
                    <div class="text-center text-gray-500 mt-5" id="no-notifications-message">No notifications yet.</div>
                </div>
            </div>
        </div>
        
    </section>
</x-app-layout>

<script>
    let existingNotificationIds = new Set(); // Track already displayed notifications

    function fetchNotifications() {
        fetch('{{ route('notifications.unread') }}')
            .then(response => response.json())
            .then(notifications => {
                const container = document.getElementById('notifications-container');
                const noNotificationsMessage = document.getElementById('no-notifications-message');

                if (notifications.length === 0) {
                    // Show "No notifications yet" message
                    noNotificationsMessage.style.display = 'block';
                } else {
                    noNotificationsMessage.style.display = 'none';

                    // Loop through notifications and add only new ones to the container
                    notifications.forEach(notification => {
                        if (!existingNotificationIds.has(notification.id)) {
                            existingNotificationIds.add(notification.id); // Mark this notification as displayed

                            const notificationElement = `
                                <div class="mt-5 border-y-2 border-black px-3 py-5">
                                    <div class="mb-4">
                                        <div>
                                            <p class="text-sm text-gray-700">
                                                <strong>Document Type:</strong> ${notification.data.document_type}
                                            </p>
                                            <p class="text-sm text-gray-700">
                                                <strong>Taxpayer Name:</strong> ${notification.data.taxpayer_name}
                                            </p>
                                            <p class="text-sm text-gray-700">
                                                <strong>Docket Owner:</strong> ${notification.data.docket_owner}
                                            </p>
                                            <p class="text-sm text-gray-700">
                                                <strong>Time Sent:</strong> ${notification.data.time_sent}
                                            </p>
                                        </div>
                                        <form action="/notifications/${notification.id}/mark-as-read" method="POST">
                                            @csrf
                                            <button type="submit" class="text-center w-full text-white bg-[#102566] px-4 py-2 rounded-md mt-4">Mark as Read</button>
                                        </form>
                                    </div>
                                </div>
                            `;
                            container.innerHTML += notificationElement; // Append the new notification
                        }
                    });
                }
            })
            .catch(error => console.error('Error fetching notifications:', error));
    }

    // Fetch notifications every 5 seconds
    setInterval(fetchNotifications, 5000);

    // Fetch notifications on page load
    fetchNotifications();
</script>
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