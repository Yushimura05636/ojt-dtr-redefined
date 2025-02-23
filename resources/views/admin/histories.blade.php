
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="app-url" content="{{ config('app.url') }}">

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>

<x-main-layout>
    <div class="h-auto w-full flex flex-col gap-5">
        <section class="flex lg:flex-row flex-col items-center justify-between w-full gap-5">
            <span class="lg:!w-1/2 w-full">
                <x-form.input id="search" name_id="search" placeholder="Search" small />
            </span>

            <input class="px-5 py-2 rounded-full cursor-pointer border border-gray-200" type="month" id="month">

            <button class="px-8 px-16 py-3 my-3 mx-3 rounded-full relative overflow-hidden font-medium text-white flex items-end justify-end gap-2 animate-transition bg-gradient-to-r from-[#F57D11] via-[#F57D11]/70 to-[#F53C11] hover:bg-[#F53C11] disabled:opacity-50 lg:text-sm text-xs cursor-pointer " name="" type="button" 
                onclick="window.location.href='{{ route('admin.histories.create') }}'">
                <p>Add Histories</p>
            </button>
        </section>

        @if(session('success'))
            <x-modal.flash-msg msg="success" />
        @endif

        @if(session('error'))
            <x-modal.flash-msg msg="error" />
        @endif

        <section class="h-auto w-full flex flex-col gap-5">
            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table id="recordsTable" class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="*:px-6 *:py-3 *:text-left *:text-sm *:font-semibold *:bg-[#F57D11] *:text-white *:text-nowrap">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Description</th>
                            <th>Date & Time</th>
                            <th>Action </th>
                        </tr>
                    </thead>
                    <tbody id="recordsBody">
                        @foreach ($records as $record)
                            <tr class="border hover:bg-gray-100 *:px-6 *:py-4 *:text-nowrap">
                                <td class="capitalize">
                                    {{ $record['user']->firstname }} {{ substr($record['user']->middlename, 0, 1) }}. {{ $record['user']->lastname }}
                                </td>
                                <td>{{ $record['user']->email }}</td>
                                <td>
                                    <span class="text-sm font-semibold 
                                        {{ $record['history']->description === 'time in' ? 
                                            (isset($record['history']->extra_description) && $record['history']->extra_description === 'late' ? 'text-red-500 font-bold' : 'text-green-500') 
                                            : 'text-red-500' }}">
                                        
                                        {{ $record['history']->description }} 
                                        @if(isset($record['history']->extra_description)) 
                                            ({{ $record['history']->extra_description }}) 
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($record['history']->datetime)->format('F d - h:i A') }}
                                </td>
                                <td>
                                    <button class="flex items-center px-4 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 013.182 3.183L8.476 18.238a4.5 4.5 0 01-1.751 1.13l-3.272 1.092a.375.375 0 01-.484-.485l1.092-3.271a4.5 4.5 0 011.13-1.752L16.862 3.487z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25L15.75 4.5" />
                                        </svg>
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>

            <!-- Pagination Controls -->
            <div class="flex lg:flex-row flex-col gap-3 items-center justify-between">
                <span id="pagination-info" class="text-sm text-gray-600"></span>
                <div class="flex items-center gap-3">
                    <button id="prev-page"
                        class="px-4 py-2 bg-gray-300 rounded disabled:opacity-50 hover:bg-[#F57D11] hover:text-white transition disabled:hover:bg-gray-300 disabled:hover:text-current"
                        disabled>Prev</button>

                    <span id="page-info">Page 1 of </span>

                    <button id="next-page"
                        class="px-4 py-2 bg-gray-300 rounded disabled:opacity-50 hover:bg-[#F57D11] hover:text-white transition disabled:hover:bg-gray-300 disabled:hover:text-current">Next</button>
                </div>
            </div>
        </section>
    </div>
</x-main-layout>

<script>

    const APP_URL = document.querySelector('meta[name="app-url"]').getAttribute("content");

    document.addEventListener("DOMContentLoaded", function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        axios.defaults.headers.common["X-CSRF-TOKEN"] = csrfToken;
        axios.defaults.headers.common["Content-Type"] = "application/json";

        let currentPage = 1;
        let perPage = 10;
        let totalRecords = 0;

        function fetchRecords(searchQuery = '', selectedMonth = '', page = 1) {
            let app_url = `{{ url('/admin/history/search') }}`;

            axios.post(app_url, {
                    query: searchQuery,
                    date: selectedMonth,
                    page: page
                })
                .then(response => {
                    let data = response.data;
                    totalRecords = data.total;
                    perPage = data.perPage;
                    currentPage = data.currentPage;

                    let recordsBody = document.getElementById('recordsBody');
                    let paginationInfo = document.getElementById('pagination-info');
                    let prevPageBtn = document.getElementById('prev-page');
                    let nextPageBtn = document.getElementById('next-page');

                    recordsBody.innerHTML = '';

                    for (let record of data.records) {
let row = document.createElement('tr');
row.classList.add('border', 'hover:bg-gray-100');

// Check if the user was late
let isLate = record.history.extra_description && record.history.extra_description === 'late';
let descriptionClass = '';

// Determine the display text for the status
let descriptionText = record.history.description;
if (isLate && record.history.description === 'time in') {
    descriptionText += ' | Late';
}

if (record.history.description === 'time in') {
    if (isLate) {
        descriptionClass = 'text-red-600 font-bold'; // Darker red for visibility
    } else {
        descriptionClass = 'text-green-600'; // Slightly darker green for better contrast
    }
} else {
    descriptionClass = 'text-red-600'; // Ensure all 'time out' values use the same color
}

// Format the date
let formattedDate = new Date(record.history.datetime)
    .toLocaleString('en-US', { month: 'long', day: '2-digit', hour: '2-digit', minute: '2-digit', hour12: true });

// Generate row content
row.innerHTML = `
    <td class="px-6 py-4 capitalize text-nowrap">
    ${record.user.firstname} ${(record.user.middlename).substring(0, 1)}. ${record.user.lastname}</td>
    <td class="px-6 py-4 text-nowrap">${record.user.email}</td>
    <td class="px-6 py-4 text-nowrap font-semibold">
        <span class="${descriptionClass}">${descriptionText}</span>
    </td>
    <td class="px-6 py-4 text-nowrap">${formattedDate}</td>
    <td>
        <a href="{{ route('admin.histories.edit', $record['history']->id) }}" 
            class="flex items-center text-center px-4 mx-5 my-5 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 013.182 3.183L8.476 18.238a4.5 4.5 0 01-1.751 1.13l-3.272 1.092a.375.375 0 01-.484-.485l1.092-3.271a4.5 4.5 0 011.13-1.752L16.862 3.487z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25L15.75 4.5" />
            </svg>
            Edit
        </a>
    </td>

`;

recordsBody.appendChild(row);
}


                    paginationInfo.textContent =
                        `Showing ${((currentPage - 1) * perPage) + 1} - ${Math.min(currentPage * perPage, totalRecords)} of ${totalRecords}`;

                    let pageInfo = document.getElementById('page-info');
                    pageInfo.textContent = `Page ${currentPage} of ${Math.ceil(totalRecords / perPage)}`;

                    prevPageBtn.disabled = currentPage === 1;
                    nextPageBtn.disabled = currentPage * perPage >= totalRecords;
                })
                .catch(error => console.error('Error:', error));
        }

        document.getElementById('search').addEventListener('keyup', function () {
            let searchQuery = this.value;
            let selectedMonth = document.getElementById('month').value;
            if (searchQuery.length > 2 || searchQuery.length === 0) {
                currentPage = 1;
                fetchRecords(searchQuery, selectedMonth, currentPage);
            }
        });

        document.getElementById('month').addEventListener('change', function () {
            let selectedMonth = this.value;
            let searchQuery = document.getElementById('search').value;
            currentPage = 1;
            fetchRecords(searchQuery, selectedMonth, currentPage);
        });

        document.getElementById('prev-page').addEventListener('click', function () {
            if (currentPage > 1) {
                currentPage--;
                let searchQuery = document.getElementById('search').value;
                let selectedMonth = document.getElementById('month').value;
                fetchRecords(searchQuery, selectedMonth, currentPage);
            }
        });

        document.getElementById('next-page').addEventListener('click', function () {
            if (currentPage * perPage < totalRecords) {
                currentPage++;
                let searchQuery = document.getElementById('search').value;
                let selectedMonth = document.getElementById('month').value;
                fetchRecords(searchQuery, selectedMonth, currentPage);
            }
        });

        let monthInput = document.getElementById("month");
        let today = new Date();
        let currentMonth = today.toISOString().slice(0, 7);
        monthInput.value = currentMonth;

        fetchRecords();
    });
</script>
