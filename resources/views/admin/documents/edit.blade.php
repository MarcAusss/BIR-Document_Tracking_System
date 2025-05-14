<x-app-layout>
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

        <div class="mt-2 bg-white rounded-lg shadow-lg px-5 py-2 w-full">
            <h1 class="text-2xl font-bold mb-4">Edit Document</h1>

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('documents.update', $document->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="document_type" class="block text-gray-700">Document Type</label>
                    <input type="text" id="document_type" name="document_type" value="{{ old('document_type', $document->document_type) }}" class="w-full border border-gray-300 rounded-md p-2">
                </div>

                <div class="mb-4">
                    <label for="taxpayer_name" class="block text-gray-700">Taxpayer Name</label>
                    <input type="text" id="taxpayer_name" name="taxpayer_name" value="{{ old('taxpayer_name', $document->taxpayer_name) }}" class="w-full border border-gray-300 rounded-md p-2">
                </div>

                <div class="mb-4">
                    <label for="taxable_period" class="block text-gray-700">Taxable Period/Year</label>
                    <input type="text" id="taxable_period" name="taxable_period" value="{{ old('taxable_period', $document->taxable_period) }}" class="w-full border border-gray-300 rounded-md p-2">
                </div>

                <div class="mb-4">
                    <label for="docket_owner" class="block text-gray-700">Docket/Document Owner</label>
                    <input type="text" id="docket_owner" name="docket_owner" value="{{ old('docket_owner', $document->docket_owner) }}" class="w-full border border-gray-300 rounded-md p-2">
                </div>

                <div class="mb-4">
                    <label for="RDO" class="block text-gray-700">RDO</label>
                    <input type="text" id="RDO" name="RDO" value="{{ old('RDO', $document->RDO) }}" class="w-full border border-gray-300 rounded-md p-2">
                </div>

                <div class="mb-4">
                    <label for="date_received" class="block text-gray-700">Date Received</label>
                    <input type="date" id="date_received" name="date_received" value="{{ old('date_received', $document->date_received->format('Y-m-d')) }}" class="w-full border border-gray-300 rounded-md p-2">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
                </div>
            </form>
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