<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<meta name="app-url" content="{{ config('app.url') }}">

<x-main-layout>
    <div class="w-full pb-5">
        <h1 class="lg:!text-2xl md:text-lg text-base mb-5 font-semibold">Requests @if ($downloadRequest->count() != 0)
                ({{ count($downloadRequest) }})
            @endif
        </h1>

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
                    <tr
                        class="*:px-6 *:py-3 *:text-left *:text-sm *:font-semibold *:bg-[#F57D11] *:text-white *:text-nowrap">
                        <th>#</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Date Requested</th>
                        <th>Date Approved</th>
                        <th>Date Declined</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $filteredRequests = collect($downloadRequest)->filter(
                            fn($request) => $activeTab === 'all' || $activeTab === $request['statusKey'],
                        );
                    @endphp

                    @forelse ($filteredRequests as $request)
                        <tr class="border hover:bg-gray-100 *:px-6 *:py-4 *:text-nowrap">
                            <td class="font-semibold text-gray-700">{{ $loop->iteration }}</td>
                            <td>{{ $request['title'] }}</td>
                            <td class="font-semibold {{ $request['statusColor'] }}">{{ $request['statusText'] }}</td>
                            <td>{{ $request['formattedDate'] }}</td>
                            <td>{{ $request['date_approved'] ?? '—' }}</td>
                            <td>{{ $request['date_declined'] ?? '—' }}</td>
                            <td class="flex items-center gap-2">
                                <div class="relative group">
                                    <button class="px-2 py-1 bg-blue-500 text-white rounded flex items-center gap-1"
                                        onclick="viewRequest({{ $request['id'] }}, {{ $request['month'] }}, {{ $request['year'] }})">
                                        <span class="basil--eye-solid w-6 h-6"></span>
                                    </button>
                                </div>

                                @if ($request['statusKey'] === 'approved')
                                    <div class="relative group">
                                        <button
                                            class="px-2 py-1 bg-green-500 text-white rounded flex items-center gap-1"
                                            onclick="downloadRequest({{ $request['id'] }}, {{ $request['month'] }}, {{ $request['year'] }})">
                                            <span class="material-symbols--download-rounded !w-6 !h-6"></span>
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="border px-6 py-4 text-nowrap text-center w-full">
                            <td colspan="7" class="text-center py-4 text-sm font-semibold text-gray-600 select-none">
                                Nothing to see here.
                            </td>
                        </tr>
                    @endforelse
                </tbody>


            </table>
        </div>

    </div>

    <script>
        const APP_URL = document.querySelector('meta[name="app-url"]').getAttribute("content");

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

        let app_url = ``;

        function viewRequest(requestId, month, year) {
            action = 'view';
            app_url = `{{ url('/request/${requestId}?&type=${action}') }}`;
            window.location.assign(app_url);
        }


        function downloadRequest(requestId, month, year) {
            action = 'download';
            app_url = "{{ url('/request') }}" + `/${requestId}?type=${action}`;
            window.open(app_url, '_blank');
        }
    </script>

</x-main-layout>
