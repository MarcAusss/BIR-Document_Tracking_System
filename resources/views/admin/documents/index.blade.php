<x-admin-app-layout>
    <section class="pt-4 mr-7">

        <div class="">
            <div class="flex items-center justify-between ">
                <div class="">
                    <nav class="text-gray-500 text-sm" aria-label="Breadcrumb">
                        <ol class="list-reset flex">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:underline">Home</a>
                            </li>
                            <li><span class="mx-2">/</span></li>
                            <li>
                                <a href="{{ route('documents.index') }}" class=" hover:underline">Documents</a>
                            </li>
                        </ol>
                    </nav>
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
                <div class="flex justify-between items-center">
                    <h1 class="">
                        <span class="text-xl font-bold">Documents List</span>
                    </h1>
                    <!-- Button to trigger modal -->
                    <div x-data="{ open: false }">
                        <button @click="open = true" class="bg-[#102566] text-white px-4 py-2 rounded-md hover:bg-blue-800 transition duration-200">
                            Add Document
                        </button>

                        <!-- Modal -->
                        <div x-show="open" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
                                <h2 class="text-xl font-bold mb-4">Add Document</h2>
                                <form action="{{ route('documents.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="taxpayer_name" class="block text-gray-700">Taxpayer Name</label>
                                        <input type="text" id="taxpayer_name" name="taxpayer_name" class="w-full border border-gray-300 rounded-md p-2" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="taxable_period" class="block text-gray-700">Taxable Period/Year</label>
                                        <input type="text" id="taxable_period" name="taxable_period" class="w-full border border-gray-300 rounded-md p-2" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="docket_owner" class="block text-gray-700">Docket/Document Owner</label>
                                        <input type="text" id="docket_owner" name="docket_owner" class="w-full border border-gray-300 rounded-md p-2" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="document_type" class="block text-gray-700">Type of Document</label>
                                        <input type="text" id="document_type" name="document_type" class="w-full border border-gray-300 rounded-md p-2" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="date_received" class="block text-gray-700">Date Received by Owner</label>
                                        <input type="date" id="date_received" name="date_received" class="w-full border border-gray-300 rounded-md p-2" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="RDO" class="block text-gray-700">RDO</label>
                                        <select id="RDO" name="RDO" class="w-full border border-gray-300 rounded-md p-2" required>
                                            <option value="64- Talisay, Camarines Sur">64 - Talisay, Camarines Sur</option>
                                            <option value="Naga City">65 - Naga City</option>
                                            <option value="Iriga City">66 - Iriga City</option>
                                            <option value="Legazpi City">67 - Legazpi City</option>
                                            <option value="Sorsogon City">68 - Sorsogon City</option>
                                            <option value="Virac, Catanduanes">69 - Virac, Catanduanes</option>
                                            <option value="Masbate">70 - Masbate</option>
                                        </select>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="button" @click="open = false" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Cancel</button>
                                        <button type="submit" class="bg-[#102566] text-white px-4 py-2 rounded-md">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>  
                </div>
                @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            </div>
            <div class="">
                <table id="documentTable" class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-[#102566] text-white">
                            <th class="px-4 py-2 w-[20px]">#</th>
                            <th class="px-4 py-2">Document Type</th>
                            <th class="px-4 py-2">Taxpayer Name</th>
                            <th class="px-4 py-2">Taxable Period/Year</th>
                            <th class="px-4 py-2">Docket/Document Owner</th>
                            <th class="px-4 py-2">RDO</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Date Received</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div x-data="{ open: false, selectedDocument: null }">
                            @forelse ($documents as $document)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $document->document_type }}</td>
                                    <td class="px-4 py-2">{{ $document->taxpayer_name }}</td>
                                    <td class="px-4 py-2">{{ $document->taxable_period }}</td>
                                    <td class="px-4 py-2">{{ $document->docket_owner }}</td>
                                    <td class="px-4 py-2">{{ $document->RDO }}</td>
                                    <td class="px-4 py-2">
                                        <select class="border-none focus:outline-none focus:border-none p-1" data-id="{{ $document->id }}" onchange="updateStatus(this)">
                                            <option value="pending" {{ $document->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="draft" {{ $document->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="finalized" {{ $document->status == 'finalized' ? 'selected' : '' }}>Finalized</option>
                                        </select>
                                    </td>
                                    <td class="px-4 py-2">{{ $document->date_received->format('F j, Y') }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex gap-2 items-center">
                                            <div x-data="{ open: false, selectedDocument: null }">
                                                <button @click="open = true; selectedDocument = {{ $document }}" 
                                                        class="bg-[#102566] text-white px-4 py-2 rounded-md hover:bg-blue-800 transition duration-200">
                                                    Send
                                                </button>

                                                <div x-show="open" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                                                    <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
                                                        <h2 class="text-xl font-bold mb-4">Send Document</h2>
                                                        <form action="{{ route('documents.send') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="document_id" :value="selectedDocument.id">
                                                            
                                                            <div class="mb-4">
                                                                <label for="document_type" class="block text-gray-700">Document Type</label>
                                                                <input type="text" id="document_type" x-model="selectedDocument.document_type" class="w-full border border-gray-300 rounded-md p-2 bg-gray-100" readonly>
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="taxpayer_name" class="block text-gray-700">Taxpayer Name</label>
                                                                <input type="text" id="taxpayer_name" x-model="selectedDocument.taxpayer_name" class="w-full border border-gray-300 rounded-md p-2 bg-gray-100" readonly>
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="time_sent" class="block text-gray-700">Time Sent</label>
                                                                <input type="text" class="time-sent w-full border border-gray-300 rounded-md p-2 bg-gray-100" readonly>
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="recipient_office" class="block text-gray-700">Recipient Office</label>
                                                                <select id="recipient_office" name="recipient_office" class="w-full border border-gray-300 rounded-md p-2" required>
                                                                    <option value="">-- Select Office --</option>
                                                                    <option value="Assessment">Assessment</option>
                                                                    <option value="Collection">Collection</option>
                                                                    <option value="Legal">Legal</option>
                                                                    <option value="Finance">Finance</option>
                                                                    <option value="AMRMD">AMRMD</option>
                                                                    <option value="RID">RID</option>
                                                                    <option value="DPD">DPD</option>
                                                                </select>
                                                            </div>
                                                            <div class="flex justify-end">
                                                                <button type="button" @click="open = false" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Cancel</button>
                                                                <button type="submit" class="bg-[#102566] text-white px-4 py-2 rounded-md">Send</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="{{ route('documents.edit', $document->id) }}" 
                                                class="bg-blue-500 text-white text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                                                    Edit
                                            </a>
                                            <form action="{{ route('documents.destroy', $document->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this document?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-2 text-center text-gray-500">No documents found.</td>
                                </tr>
                            @endforelse
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    
    </section>
    <script>
        function updateStatus(selectElement) {
            const documentId = selectElement.getAttribute('data-id');
            const newStatus = selectElement.value;

            fetch(`/documents/${documentId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ status: newStatus }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Status updated successfully!');
                } else {
                    alert('Failed to update status.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the status.');
            });
        }
    </script>

    <script>
        function updateTimeSent() {
            const timeSentInputs = document.querySelectorAll('.time-sent'); // Select all elements with class="time-sent"
            const now = new Date();
            const formattedTime = now.toLocaleString('en-US', {
                month: 'long',
                day: 'numeric',
                year: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: true,
            });

            timeSentInputs.forEach(input => {
                input.value = formattedTime; // Update the value of each input
            });
        }

        // Update the time every second
        setInterval(updateTimeSent, 1000);

        // Initialize the time on page load
        updateTimeSent();
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
</x-admin-app-layout>
