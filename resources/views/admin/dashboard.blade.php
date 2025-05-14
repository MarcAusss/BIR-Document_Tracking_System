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
                <div class="bg-white mt-2 rounded-lg shadow-lg">
                    <div class="flex p-5 justify-center gap-4">
                        <div class="flex gap-4 border-x-2 border-gray-300 items-center justify-center px-10">
                            <img src="{{ url('img/document.png')}}" alt="" class="w-[40px]">
                            <div class="">
                                <h1 class="text-center text-md font-bold text-gray-800">
                                    Document
                                </h1>
                                <h1 class="text-3xl text-gray-800">
                                    {{ $totalDocuments }}
                                </h1>
                            </div>
                        </div>
                        <div class="flex gap-4 border-x-2 border-gray-300 items-center justify-center px-10">
                            <img src="{{ url('img/user.png')}}" alt="" class="w-[40px]">
                            <div class="">
                                <h1 class="text-center text-md font-bold text-gray-800">
                                    Users
                                </h1>
                                <h1 class="text-3xl text-gray-800">
                                    {{ $totalUsers }}
                                </h1>
                            </div>
                        </div>
                        <div class="flex gap-4 border-x-2 border-gray-300 items-center justify-center px-10">
                            <img src="{{ url('img/file.png')}}" alt="" class="w-[40px]">
                            <div class="">
                                <h1 class="text-center text-md font-bold text-gray-800">
                                    Pending
                                </h1>
                                <h1 class="text-3xl text-gray-800">
                                    {{ $pendingDocumentsCount }}
                                </h1>
                            </div>
                        </div>
                        <div class="flex gap-4 border-x-2 border-gray-300 items-center justify-center px-10">
                            <img src="{{ url('img/user.png')}}" alt="" class="w-[40px]">
                            <div class="">
                                <h1 class="text-md font-bold text-gray-800">
                                    Received Documents
                                </h1>
                                <h1 class="text-3xl text-gray-800">
                                    {{ $receivedDocumentsCount }}
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2 bg-white rounded-lg shadow-lg px-5 py-2 w-full">
                    <div class="">
                        <table id="documentTable" class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-[#102566] text-white">
                                    <th class="px-4 py-2 w-[50px]">#</th>
                                    <th class="px-4 py-2">Taxpayer Name</th>
                                    <th class="px-4 py-2">Document Type</th>
                                    <th class="px-4 py-2">Sender</th>
                                    <th class="px-4 py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentDocuments as $document)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2">{{ $document->taxpayer_name }}</td>
                                        <td class="px-4 py-2">{{ $document->document_type }}</td>
                                        <td class="px-4 py-2">{{ $document->docket_owner }}</td>
                                        <td class="px-4 py-2">{{ ucfirst($document->status) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">No recent documents found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            <div class="w-[450px] bg-white h-[87vh] mt-2 rounded-lg shadow-lg overflow-y-auto">
                <h1 class="text-md text-center pb-5 mx-5 border-b-2 border-black p-5">Notification of Document Status</h1>
                <div class="overflow-y-auto h-[75vh] w-full px-2">
                    @forelse ($readNotificationsWithDocuments as $notification)
                        <div class="mt-5 border-y-2 border-black px-3 py-5">
                            <h1 class="text-lg font-bold">Document Type: {{ $notification->document_type }}</h1>
                            <div class="mb-4">
                                <p class="text-gray-800">
                                    <strong>Taxpayer Name:</strong> {{ $notification->taxpayer_name }}
                                </p>
                                <p class="text-gray-800">
                                    <strong>Docket Owner:</strong> {{ $notification->docket_owner }}
                                </p>
                            </div>
                            <div class="mb-4">
                                <p class="text-gray-800">
                                    <strong>Recipient Office:</strong> {{ $notification->recipient_office }}
                                </p>
                                <p class="text-gray-800">
                                    <strong class="text-[#102566]">Time Sent:</strong> {{ \Carbon\Carbon::parse($notification->time_sent)->format('F j, Y g:i A') }}
                                </p>
                            </div>
                            <div class="mb-4">
                                <p class="text-gray-600 bg-[#FFCF13] px-4 py-2 rounded-md">
                                    <strong class="">Read At:</strong> {{ \Carbon\Carbon::parse($notification->read_at)->format('F j, Y g:i A') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 mt-5">No read notifications found with document details.</div>
                    @endforelse
                </div>
            </div>
        </div>
        
    </section>

    <div x-data="{ isOpen: false, action: '', documentId: null }">
        <div 
            x-show="isOpen" 
            class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
                <h2 class="text-xl font-bold mb-4">Confirm Action</h2>
                <p class="mb-4">Are you sure you want to <span x-text="action"></span> this document?</p>
                <div class="flex justify-end gap-4">
                    <button 
                        @click="isOpen = false" 
                        class="bg-gray-500 text-white px-4 py-2 rounded-md">
                        Cancel
                    </button>
                    <button 
                        @click="confirmAction()" 
                        class="bg-[#102566] text-white px-4 py-2 rounded-md">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(action, documentId) {
            const modal = document.querySelector('[x-data]');
            modal.__x.$data.isOpen = true; 
            modal.__x.$data.action = action; 
            modal.__x.$data.documentId = documentId; 
        }

        function confirmAction() {
            const modal = document.querySelector('[x-data]');
            const action = modal.__x.$data.action;
            const documentId = modal.__x.$data.documentId;

            
            fetch(`/documents/${documentId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ status: action }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Document status updated successfully!');
                    location.reload(); 
                } else {
                    alert('Failed to update document status.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the document status.');
            });

            
            modal.__x.$data.isOpen = false;
        }
    </script>
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