
<x-main-layout>
    <div class="w-full pb-5">
        <h1 class="lg:!text-2xl md:text-lg text-base mb-5 font-semibold">Requests ({{count($downloadRequest)}})</h1>

        <!-- Tabs & Search Bar -->
        <div class="flex lg:!flex-row flex-col justify-between gap-5 items-center">

            <!-- Search Input -->
            <div class="lg:!w-1/2 w-full">
                <x-form.input type="text" name_id="search" placeholder="Search" small />
            </div>

            <div class="flex">
                @php
                    $tabs = [
                        'all' => 'All',
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'declined' => 'Declined',
                    ];
                    $activeTab = request('status', 'all');
                @endphp

                @foreach ($tabs as $key => $label)
                    <a href="?status={{ $key }}"
                        class="px-4 py-2 {{ $activeTab === $key ? 'border-b-2 border-[#F57D11] text-[#F57D11] font-semibold' : 'text-gray-500 hover:text-black' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg mt-5">
            <table id="recordsTable" class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="*:px-6 *:py-3 *:text-left *:text-sm *:font-semibold *:bg-[#F57D11] *:text-white">
                        <th>#</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Date Requested</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $requests = [];

                        // Generate the request data
                        foreach (range(1, 15) as $i) {
                            $statuses = [
                                'pending' => 'Waiting for approval',
                                'approved' => 'Ready to download',
                                'declined' => 'Declined',
                            ];
                            $statusKey = array_rand($statuses);
                            $requests[] = [
                                'title' => 'Request for DTR Approval',
                                'statusKey' => $statusKey,
                                'statusText' => $statuses[$statusKey],
                                'statusColor' =>
                                    $statusKey === 'approved'
                                        ? 'text-green-500'
                                        : ($statusKey === 'pending'
                                            ? 'text-blue-500'
                                            : 'text-red-500'),
                                'date' => strtotime('2025-02-' . (20 - $i)), // Convert date to timestamp for sorting
                                'formattedDate' => 'Feb ' . (20 - $i) . ', 2025', // Display format
                            ];
                        }

                        // Sort the requests by date (latest first)
                        usort($requests, fn($a, $b) => $b['date'] <=> $a['date']);

                        $rowNumber = 1; // Initialize numbering
                    @endphp

                    @foreach ($downloadRequest as $request)
                        @if ($activeTab === 'all' || $activeTab === $request['statusKey'])
                            <tr class="border hover:bg-gray-100 *:px-6 *:py-4">
                                <td class="font-semibold text-gray-700">{{ $rowNumber++ }}</td>
                                <!-- Sequential numbering for each tab -->
                                <td>{{ $request['title'] }}</td>
                                <td class="font-semibold {{ $request['statusColor'] }}">{{ $request['statusText'] }}
                                </td>
                                <td>{{ $request['formattedDate'] }}</td>
                                <td class="flex items-center gap-2">
                                    <!-- View Button -->
                                    <div class="relative group">
                                        <button
                                            class="px-2 py-1 bg-blue-500 text-white rounded flex items-center gap-1"
                                            onclick="viewRequest({{$request['id']}}, {{$request['month']}}, {{$request['year']}})">
                                            <span class="basil--eye-solid w-6 h-6"></span>
                                        </button>
                                        <span
                                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition">
                                            View
                                        </span>
                                    </div>

                                    <!-- Download Button (Only if Approved) -->
                                    @if ($request['statusKey'] === 'approved')
                                        <div class="relative group">
                                            <button 
                                                class="px-2 py-1 bg-green-500 text-white rounded flex items-center gap-1"
                                                onclick="downloadRequest({{$request['id']}}, {{$request['month']}}, {{$request['year']}})">
                                                <span class="material-symbols--download-rounded w-6 h-6"></span>
                                            </button>
                                            <span
                                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition">
                                                Download
                                            </span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>

            </table>
        </div>

        <p class="mt-5">No pagination yet.</p>
    </div>

    <!-- JavaScript for Search Filtering -->
    <script>
        document.getElementById('search').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#recordsTable tbody tr');

            rows.forEach(row => {
                let title = row.children[1].textContent.toLowerCase();
                let status = row.children[2].textContent.toLowerCase();
                let date = row.children[3].textContent.toLowerCase();

                let textContent = title + " " + status + " " + date; // Combine all searchable fields

                row.style.display = textContent.includes(filter) ? '' : 'none';
            });
        });

        let app_url = `{{ url('dtr-view/${requestId}?month=${month}&year=${year}&type=view') }}`

        function viewRequest(requestId, month, year) {
            action = 'view';
            app_url = `{{ url('dtr-view/${requestId}?month=${month}&year=${year}&type=${action}') }}`
            window.location.href = app_url;
        }


        function downloadRequest(requestId, month, year) {
            action = `download`;
            app_url = `{{ url('dtr-view/${requestId}?month=${month}&year=${year}&type=${action}') }}`
            window.location.href = app_url;
        }

    </script>

</x-main-layout>
