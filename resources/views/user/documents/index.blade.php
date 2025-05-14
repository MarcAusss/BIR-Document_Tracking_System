<x-app-layout>
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
                </div>
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
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($documents as $document)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td> 
                                <td class="px-4 py-2">{{ $document->document_type }}</td>
                                <td class="px-4 py-2">{{ $document->taxpayer_name }}</td>
                                <td class="px-4 py-2">{{ $document->taxable_period }}</td>
                                <td class="px-4 py-2">{{ $document->docket_owner }}</td>
                                <td class="px-4 py-2">{{ $document->RDO }}</td> 
                                <td class="px-4 py-2">{{ $document->status }}</td>
                                <td class="px-4 py-2">{{ $document->date_received->format('F j, Y') }}</td> 
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-2 text-center text-gray-500">No documents found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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