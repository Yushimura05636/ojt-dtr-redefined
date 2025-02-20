<x-main-layout>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <meta name="app-url" content="{{ config('app.url') }}">


    <div class="h-auto w-full flex flex-col gap-5">
        <div class="flex justify-between items-center flex-wrap gap-5 w-full">
            <span class="lg:!w-1/2 w-full">
                <x-form.input id="search" name_id="search" placeholder="Search" small />
            </span>
            <div class="flex items-center gap-2 flex-wrap">
                <button id="btn-approve"
                    class="px-3 py-2 bg-green-500 text-white rounded disabled:opacity-50 flex items-center gap-2"
                    disabled>
                    <span class="uil--check w-6 h-6"></span>
                    <p class="text-sm font-semibold">Approve All</p>
                </button>
                <button id="btn-decline"
                    class="px-3 py-2 bg-red-500 text-white rounded disabled:opacity-50 flex items-center gap-2"
                    disabled>
                    <span class="iconamoon--close-light w-6 h-6"></span>
                    <p class="text-sm font-semibold">Decline All</p>
                </button>
                <button id="btn-clear" class="px-3 py-2 bg-gray-500 text-white rounded disabled:opacity-50" disabled>
                    <p class="text-base font-semibold">Clear Selection</p>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table id="recordsTable" class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr
                        class="*:px-6 *:py-3 *:text-left *:text-sm *:font-semibold *:bg-[#F57D11] *:text-white *:text-nowrap">
                        <th><input type="checkbox" id="select-all" class="cursor-pointer"></th>
                        <th>Name</th>
                        <th>Title</th>
                        <th>DTR</th>
                        <th>Date Requested</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @php
                        $pendingApprovals = collect($approvals)->where('status', 'pending');
                    @endphp

                    @if ($pendingApprovals->isNotEmpty())
                        @foreach ($pendingApprovals as $approval)
                            <tr class="border hover:bg-gray-50 *:px-6 *:py-4 row-item *:text-nowrap"
                                data-id="{{ $approval['id'] }}">
                                <td>
                                    <input type="checkbox" class="row-checkbox cursor-pointer"
                                        value="{{ $approval['id'] }}">
                                </td>
                                <td class="capitalize">{{ $approval['name'] }}</td>
                                <td>{{ $approval['title'] }}</td>
                                <td class="font-semibold text-orange-600">
                                    {{ \Carbon\Carbon::createFromDate($approval['year'], $approval['month'])->format('F Y') }}
                                </td>
                                <td>{{ $approval['date_requested'] }}</td>
                                <td class="hidden">{{ $approval['month'] }}</td>
                                <td class="hidden">{{ $approval['year'] }}</td>
                                <td class="hidden">{{ $approval['user_id'] }}</td>
                                <td class="flex items-center gap-2">
                                    <div class="relative group">
                                        <button
                                            class="view-btn px-2 py-1 bg-blue-500 text-white rounded flex items-center justify-center gap-1"
                                            data-id="{{ $approval['id'] }}">
                                            <span class="basil--eye-solid w-6 h-6"></span>
                                            <span
                                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition">
                                                View
                                            </span>
                                        </button>
                                    </div>

                                    <div class="relative group">
                                        <button
                                            class="approve-btn px-2 py-1 bg-green-500 text-white rounded flex items-center justify-center gap-1"
                                            data-id="{{ $approval['id'] }}">
                                            <span class="uil--check w-6 h-6"></span>
                                            <span
                                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition">
                                                Approve
                                            </span>
                                        </button>
                                    </div>

                                    <div class="relative group">
                                        <button
                                            class="decline-btn px-2 py-1 bg-red-500 text-white rounded flex items-center justify-center gap-1"
                                            data-id="{{ $approval['id'] }}">
                                            <span class="iconamoon--close-light w-6 h-6"></span>
                                            <span
                                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition">
                                                Decline
                                            </span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="border text-nowrap text-center">
                            <td colspan="6" class="text-center py-4 text-sm font-semibold text-gray-600 select-none">
                                Nothing to see here.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <script>
        let action = '';

        const APP_URL = document.querySelector('meta[name="app-url"]').getAttribute("content");

        document.addEventListener("DOMContentLoaded", function() {
            const selectAllCheckbox = document.getElementById("select-all");
            const checkboxes = document.querySelectorAll(".row-checkbox");
            const rows = document.querySelectorAll(".row-item");
            const approveButton = document.getElementById("btn-approve");
            const declineButton = document.getElementById("btn-decline");
            const clearButton = document.getElementById("btn-clear");
            const searchInput = document.getElementById("search");

            function getSelectedIds() {
                return Array.from(document.querySelectorAll(".row-checkbox:checked")).map(cb => cb.value);
            }

            function updateActionButtons() {
                const selectedIds = getSelectedIds();
                approveButton.disabled = declineButton.disabled = selectedIds.length === 0;
                clearButton.disabled = selectedIds.length < 2;
            }

            selectAllCheckbox.addEventListener("change", function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                    toggleRowSelection(checkbox.closest("tr"), checkbox.checked);
                });
                updateActionButtons();
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", function() {
                    toggleRowSelection(checkbox.closest("tr"), checkbox.checked);
                    updateActionButtons();
                });
            });

            function toggleRowSelection(row, isSelected) {
                row.classList.toggle("bg-[#F57D11]/20", isSelected);
            }

            clearButton.addEventListener("click", function() {
                checkboxes.forEach(checkbox => checkbox.checked = false);
                selectAllCheckbox.checked = false;
                updateActionButtons();
            });

            searchInput.addEventListener("keyup", function() {
                const searchTerm = searchInput.value.toLowerCase();
                rows.forEach(row => {
                    const name = row.cells[1].textContent.toLowerCase();
                    const title = row.cells[2].textContent.toLowerCase();
                    const dateRequested = row.cells[3].textContent.toLowerCase();
                    row.style.display = name.includes(searchTerm) || title.includes(searchTerm) ||
                        dateRequested.includes(searchTerm) ? "" : "none";
                });
            });

            document.querySelectorAll(".approve-btn, .decline-btn, .view-btn").forEach(button => {
                button.addEventListener("click", function() {
                    let row = this.closest("tr"); // Find the nearest <tr>

                    if (!row) {
                        console.error("❌ No <tr> found! Check your table structure.");
                        return;
                    }

                    // Get <td> elements by index
                    let cells = row.querySelectorAll("td");

                    if (cells.length < 3) {
                        console.warn("⚠ Expected at least 3 columns, but found:", cells.length);
                        return;
                    }

                    let name = cells[1] ? cells[1].textContent.trim() : "N/A";
                    let requestType = cells[2] ? cells[2].textContent.trim() : "N/A";
                    let date = cells[3] ? cells[3].textContent.trim() : "N/A";
                    let month = cells[5] ? cells[5].textContent.trim() : "N/A";
                    let year = cells[6] ? cells[6].textContent.trim() : "N/A";
                    let user_id = cells[7] ? cells[7].textContent.trim() : "N/A";

                    // Get ID from data attributes (assuming it's stored in <td> or <tr>)
                    let requestId = row.dataset.id || this.dataset.id;
                    let toUserId = row.dataset.to_user_id || this.dataset.to_user_id;


                    let actionType = "";

                    //let apiUrl = `/public/admin-dtr-`; // Adjust this to your actual Laravel API route
                    let app_url = `{{ url('/admin-dtr-') }}`;

                    let requestData = {
                        id: requestId,
                        name: name,
                        request_type: requestType,
                        month: month,
                        year: year,
                        hello: toUserId,
                        to_user_id: user_id,
                        from_user_id: 1,
                    };

                    if (this.classList.contains("approve-btn")) {
                        actionType = "approve";
                        requestData.status = "approved";

                        axios.post(app_url + actionType, requestData)
                            .then(response => {
                                alert("Request approved successfully!");
                            })
                            .catch(error => {
                                console.error("❌ Approval Failed:", error);
                                alert("Error approving request.");
                            });

                    } else if (this.classList.contains("decline-btn")) {
                        actionType = "decline";
                        requestData.status = "declined";

                        axios.post(app_url + actionType, requestData)
                            .then(response => {
                                alert("Request declined successfully!");
                            })
                            .catch(error => {
                                console.error("❌ Decline Failed:", error);
                                alert("Error declining request.");
                            });

                    } else if (this.classList.contains("view-btn")) {
                        actionType = "view";
                        app_url = `{{ url('/admin/approvals/${requestId}?&type=${actionType}') }}`;
                        window.location.href = app_url; // Change the URL as needed
                    }

                });
            });


            let app_url = `{{ url('/admin-dtr-batch-') }}`;

            // Approve All Function
            approveButton.addEventListener("click", function() {
                const selectedIds = getSelectedIds();
                if (selectedIds.length > 0) {

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                        "content");

                    //const url = '/public/admin-dtr-batch-approve';
                    //let app_url = `{{ url('/admin/-dtr-batch-approve') }}`;

                    action = 'approve';

                    fetch(app_url + action, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrfToken,
                            },
                            body: JSON.stringify({
                                selectedIds
                            }),
                        })
                        .then(response => {
                            if (response.status === 200) {
                                toastr.success(`DTR request ${action}d successfully.`);
                            } else {
                                toastr.error(`Failed to ${action} DTR request.`);
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            toastr.error("Something went wrong. Try again.");
                        });
                    // Add logic to process approvals
                }
            });

            // Decline All Function
            declineButton.addEventListener("click", function() {
                const selectedIds = getSelectedIds();
                if (selectedIds.length > 0) {

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                        "content");
                    //const url = '/public/admin-dtr-batch-decline';

                    action = 'decline';

                    fetch(app_url + action, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrfToken,
                            },
                            body: JSON.stringify({
                                selectedIds
                            }),
                        })
                        .then(response => {
                            if (response.status === 200) {
                                toastr.success(`DTR request ${action}d successfully.`);
                            } else {
                                toastr.error(`Failed to ${action} DTR request.`);
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            toastr.error("Something went wrong. Try again.");
                        });
                    // Add logic to process approvals
                }
            });

            clearButton.addEventListener("click", function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                    toggleRowSelection(checkbox.closest("tr"), false); // Reset row color
                });
                selectAllCheckbox.checked = false;
                updateActionButtons();
            });

            // Function to toggle row background color
            function toggleRowSelection(row, isSelected) {
                if (isSelected) {
                    row.classList.add("bg-gray-100");
                } else {
                    row.classList.remove("bg-gray-100"); // Ensure color resets
                }
            }
        });

        function searchApprovals(searchTerm, approvals) {
            searchTerm = searchTerm.toLowerCase();

            return approvals.filter(approval =>
                approval.name.toLowerCase().includes(searchTerm) ||
                approval.title.toLowerCase().includes(searchTerm) ||
                approval.date_requested.toLowerCase().includes(searchTerm)
            );

            let app_url = `{{ url('/admin-dtr-') }}`;


            //this is the handle request function for approval and denial
            function handleDtrRequest(action, toUserId, month, year) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
                const url = action === 'accept' ? app_url + action : app_url + decline; // Change to your actual endpoints

                fetch(url, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        body: JSON.stringify({
                            to_user_id: toUserId,
                            from_user_id: 1,
                            month: month,
                            year: year,
                        }),
                    })
                    .then(response => {
                        if (response.status === 200) {
                            toastr.success(`DTR request ${action}ed successfully.`);
                        } else {
                            toastr.error(`Failed to ${action} DTR request.`);
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        toastr.error("Something went wrong. Try again.");
                    });
            }
        }

        const filteredApprovals = searchApprovals(searchTerm, approvals);
    </script>
</x-main-layout>
