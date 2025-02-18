<x-main-layout>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <div class="h-auto w-full flex flex-col gap-5">
        <div class="flex justify-between items-center flex-wrap gap-5 w-full">
            <span class="lg:!w-1/2 w-full">
                <x-form.input id="search" name_id="search" placeholder="Search" small />
            </span>
            <div class="flex items-center gap-2 flex-wrap">
                <button id="btn-approve" class="px-3 py-2 bg-green-500 text-white rounded disabled:opacity-50 flex items-center gap-2" disabled>
                    <span class="uil--check w-6 h-6"></span>
                    <p class="text-sm font-semibold">Approve All</p>
                </button>
                <button id="btn-decline" class="px-3 py-2 bg-red-500 text-white rounded disabled:opacity-50 flex items-center gap-2" disabled>
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
                    <tr class="*:px-6 *:py-3 *:text-left *:text-sm *:font-semibold *:bg-[#F57D11] *:text-white">
                        <th><input type="checkbox" id="select-all" class="cursor-pointer"></th>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Date Requested</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    {{-- @php
                        $approvals = collect(range(1, 10))->map(fn($i) => [
                            'id' => $i,
                            'name' => 'John Doe ' . $i,
                            'title' => 'Request for Approval ' . $i,
                            'date_requested' => now()->subDays($i)->format('Y-m-d'),
                        ])->sortByDesc('date_requested');
                    @endphp --}}

                    @forelse ($approvals as $approval)
                        @if($approval['status'] === 'pending')
                            <tr class="border hover:bg-gray-50 *:px-6 *:py-4 row-item" data-id="{{ $approval['id'] }}">
                                <td class="text-center">
                                    <input type="checkbox" class="row-checkbox cursor-pointer" value="{{ $approval['id'] }}">
                                </td>
                                <td>{{ $approval['name'] }}</td>
                                <td>{{ $approval['title'] }}</td>
                                <td>{{ $approval['date_requested'] }}</td>
                                <td class="hidden">{{ $approval['month'] }}</td>
                                <td class="hidden">{{ $approval['year'] }}</td>
                                <td class="hidden">{{ $approval['user_id'] }}</td>
                                <td class="flex items-center gap-2">
                                    
                                    <div class="relative group">
                                        <button class="view-btn px-2 py-1 bg-blue-500 text-white rounded flex items-center justify-center gap-1" data-id="{{ $approval['id'] }}">
                                            <span class="basil--eye-solid w-6 h-6"></span>
                                            <span
                                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition">
                                                View
                                            </span>
                                        </button>
                                    </div>
                                
                                    <div class="relative group">
                                        <button class="approve-btn px-2 py-1 bg-green-500 text-white rounded flex items-center justify-center gap-1" data-id="{{ $approval['id'] }}">
                                            <span class="uil--check w-6 h-6"></span>
                                            <span
                                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition">
                                                Approve
                                            </span>
                                        </button>
                                    </div>
                                
                                    <div class="relative group">
                                        <button class="decline-btn px-2 py-1 bg-red-500 text-white rounded flex items-center justify-center gap-1" data-id="{{ $approval['id'] }}">
                                            <span class="iconamoon--close-light w-6 h-6"></span>
                                            <span
                                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition">
                                                Decline
                                            </span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No Data Available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>

        let action = '';

        document.addEventListener("DOMContentLoaded", function () {
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

            selectAllCheckbox.addEventListener("change", function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                    toggleRowSelection(checkbox.closest("tr"), checkbox.checked);
                });
                updateActionButtons();
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", function () {
                    toggleRowSelection(checkbox.closest("tr"), checkbox.checked);
                    updateActionButtons();
                });
            });

            function toggleRowSelection(row, isSelected) {
                row.classList.toggle("bg-[#F57D11]/20", isSelected);
            }

            clearButton.addEventListener("click", function () {
                checkboxes.forEach(checkbox => checkbox.checked = false);
                selectAllCheckbox.checked = false;
                updateActionButtons();
            });

            searchInput.addEventListener("keyup", function () {
                const searchTerm = searchInput.value.toLowerCase();
                rows.forEach(row => {
                    const name = row.cells[1].textContent.toLowerCase();
                    const title = row.cells[2].textContent.toLowerCase();
                    const dateRequested = row.cells[3].textContent.toLowerCase();
                    row.style.display = name.includes(searchTerm) || title.includes(searchTerm) || dateRequested.includes(searchTerm) ? "" : "none";
                });
            });

            document.querySelectorAll(".approve-btn, .decline-btn, .view-btn").forEach(button => {
    button.addEventListener("click", function () {
        let row = this.closest("tr"); // Find the nearest <tr>

        console.log("🔍 Clicked Button:", this);
        console.log("📌 Found Row:", row);

        if (!row) {
            console.error("❌ No <tr> found! Check your table structure.");
            return;
        }

        // Debugging: Print the full row's inner HTML
        console.log("🔎 Full Row HTML:", row.innerHTML);

        // Get <td> elements by index
        let cells = row.querySelectorAll("td");

        console.log("📊 All Cells:", cells); // Debug all cells

        if (cells.length < 3) {
            console.warn("⚠ Expected at least 3 columns, but found:", cells.length);
            return;
        }

        let name = cells[1] ? cells[1].textContent.trim() : "N/A";
        let requestType = cells[2] ? cells[2].textContent.trim() : "N/A";
        let date = cells[3] ? cells[3].textContent.trim() : "N/A";
        let month = cells[4] ? cells[4].textContent.trim() : "N/A";
        let year = cells[5] ? cells[5].textContent.trim() : "N/A";
        let user_id = cells[6] ? cells[6].textContent.trim() : "N/A";

        console.log("📛 Name Column:", name);
        console.log("📜 Request Type Column:", requestType);
        console.log("📅 Date Column:", date);

        // Get ID from data attributes (assuming it's stored in <td> or <tr>)
        let requestId = row.dataset.id || this.dataset.id; 
        let toUserId = row.dataset.to_user_id || this.dataset.to_user_id; 

        console.log("🆔 Request ID:", requestId);
        console.log("👤 To User ID:", toUserId);

        let actionType = "";
        let apiUrl = "/admin-dtr-"; // Adjust this to your actual Laravel API route
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
            actionType = "Approved";
            requestData.status = "approved";

            axios.post(apiUrl+'approve', requestData)
                .then(response => {
                    console.log("✅ Approval Success:", response.data);
                    alert("Request approved successfully!");
                })
                .catch(error => {
                    console.error("❌ Approval Failed:", error);
                    alert("Error approving request.");
                });

        } else if (this.classList.contains("decline-btn")) {
            actionType = "Declined";
            requestData.status = "declined";

            axios.post(apiUrl+'decline', requestData)
                .then(response => {
                    console.log("✅ Decline Success:", response.data);
                    alert("Request declined successfully!");
                })
                .catch(error => {
                    console.error("❌ Decline Failed:", error);
                    alert("Error declining request.");
                });

        } else if (this.classList.contains("view-btn")) {
            actionType = "Viewed";
            window.location.href = `/admin/approvals/${requestId}?&type=view`; // Change the URL as needed
        }

        console.log("🆔 Button Clicked:", actionType);
    });
});


            // Approve All Function
            approveButton.addEventListener("click", function () {
                const selectedIds = getSelectedIds();
                if (selectedIds.length > 0) {
                    console.log("Approving all selected IDs:", selectedIds);

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
                    const url = '/admin-dtr-batch-approve';

                    action = 'approve';

                    fetch(url, {
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
            declineButton.addEventListener("click", function () {
                const selectedIds = getSelectedIds();
                if (selectedIds.length > 0) {
                    console.log("Declining all selected IDs:", selectedIds);

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
                    const url = '/admin-dtr-batch-decline';

                    action = 'decline';

                    fetch(url, {
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
                        console.log(response);
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

            clearButton.addEventListener("click", function () {
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
    

    //this is the handle request function for approval and denial
    function handleDtrRequest(action, toUserId, month, year) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        const url = action === 'accept' ? "/admin-dtr-approve" : "/admin-dtr-decline"; // Change to your actual endpoints

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
console.log(filteredApprovals);
    </script>
</x-main-layout>
