<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- jQuery (Required for Toastr) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<x-main-layout>
    <main class="w-full">
        {{-- <x-modal.dtr-summary id="dtr-summary-modal" /> --}}
        <div class="flex flex-col gap-5 w-full items-center justify-center pb-5">
            <div
                class="w-full grid grid-cols-2 text-nowrap gap-5 bg-white p-3 border border-gray-200 shadow-lg sticky top-[125px] z-30 rounded-full max-w-screen-xl mx-auto">

                <section class="col-span-1 flex items-center justify-start">
                    <x-button routePath="admin.approvals" label="Back" tertiary button showLabel="{{ true }}"
                        leftIcon="eva--arrow-back-fill" className="lg:px-8 px-3" />
                </section>

                <section class="flex items-center gap-3 col-span-1 justify-end w-full h-auto">
                    <button
                        name="approved_button"
                        class="approve-btn hover:bg-green-600 rounded-full lg:px-8 px-3 py-2 text-sm bg-green-500 text-white flex items-center justify-center gap-1">
                        <span class="uil--check w-6 h-6"></span>Approve
                    </button>

                    <button
                        name="declined_button"
                        class="decline-btn hover:bg-red-600 rounded-full lg:px-8 px-3 py-2 text-sm bg-red-500 text-white flex items-center justify-center gap-1">
                        <span class="iconamoon--close-light w-6 h-6"></span>Decline
                    </button>
                </section>
            </div>
            <div class="xl:w-[75%] lg:w-[85%] md:w-[95%] w-[100%] h-auto mt-8">
                <div
                    class="w-auto h-auto border bg-white border-gray-100 shadow-md resize-none p-8 space-y-5 select-none">
                    <section class="flex items-start justify-between">
                        <x-logo width="lg:w-[200px] w-[150px]" />
                        <x-image path="resources/img/school-logo/sti.png" className="lg:w-16 w-12 h-auto" />
                    </section>
                    <section class="my-7 text-center">
                        <p class="text-[#F57D11] font-semibold sm:text-base text-sm">OJT Daily Time Record</p>
                        <h1 class="lg:text-xl sm:text-lg text-base md:mt-2 font-bold">
                            {{ $pagination['currentMonth']['name'] }}</h1>
                    </section>
                    <hr>
                    <section class="sm:space-y-2">
                        <p class="lg:text-sm text-xs font-semibold">Name: <span
                                class="font-normal lg:text-base text-sm capitalize">{{ $user->firstname }}
                                {{ $user->middlename }}
                                {{ $user->lastname }}</span></p>
                        <p class="lg:text-sm text-xs font-semibold">Position: <span
                                class="font-normal lg:text-base text-sm">Intern</span>
                        </p>
                        <div class="flex items-center justify-between gap-3">
                            <p class="lg:text-sm text-xs font-semibold">Total Time This Month: <span
                                    class="font-normal lg:text-base text-sm">{{ floor((int) filter_var($totalHoursPerMonth, FILTER_SANITIZE_NUMBER_INT) / 60) }}
                                    hours
                                    {{ round((int) filter_var($totalHoursPerMonth, FILTER_SANITIZE_NUMBER_INT) % 60) }}
                                    minutes</span></p>
                        </div>
                    </section>

                    <input type="text" name='monthValue' class="hidden" value="{{$pagination['currentMonth']['month']}}" />
                    <input type="text" name='yearValue' class="hidden" value="{{$pagination['currentMonth']['year']}}" />
                    <input type="text" name='toUserValue' class="hidden" value="{{$user->id}}" />
                    <input type="text" name='requestId' class="hidden" value="{{$id}}" />

                    <section class="h-auto w-full border border-gray-200 overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th
                                        class="border lg:text-sm sm:text-xs text-[10px] text-white bg-[#F57D11] border-[#F57D11]/80 px-4 py-2">
                                        Day
                                    </th>
                                    <th
                                        class="border lg:text-sm sm:text-xs text-[10px] text-white bg-[#F57D11] border-[#F57D11]/80 px-4 py-2">
                                        Time In</th>
                                    <th
                                        class="border lg:text-sm sm:text-xs text-[10px] text-white bg-[#F57D11] border-[#F57D11]/80 px-4 py-2">
                                        Time Out
                                    </th>
                                    <th
                                        class="border lg:text-sm sm:text-xs text-[10px] text-white bg-[#F57D11] border-[#F57D11]/80 px-4 py-2">
                                        Total Time
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($records) && count($records) > 0)
                                    @foreach ($records as $date => $data)
                                    <tr class="text-center">
                                        <td
                                                class="border border-gray-300 px-4 py-2 lg:text-base sm:text-sm text-[10px]">
                                                {{ \Carbon\Carbon::parse($data['date'])->format(' j') }}</td>
                                            <td
                                                class="border border-gray-300 px-4 py-2 lg:text-base sm:text-sm text-[10px]">
                                                {{ $data['time_in'] }}</td>
                                            <td
                                                class="border border-gray-300 px-4 py-2 lg:text-base sm:text-sm text-[10px]">
                                                {{ $data['time_out'] }}
                                            </td>
                                            @if ($data['hours_worked'] == '—')
                                                <td
                                                class="border border-gray-300 px-4 py-2 lg:text-base sm:text-sm text-[10px]">
                                                —
                                            </td>
                                            @else
                                                @if ((int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) / 60 < 1)
                                            <td
                                                class="border border-gray-300 px-4 py-2 lg:text-base sm:text-sm text-[10px]">
                                                {{ (int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) }}
                                                minutes
                                            </td>
                                        @elseif((int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) / 60 == 1)
                                         <td
                                            class="border border-gray-300 px-4 py-2 lg:text-base sm:text-sm text-[10px]">
                                            {{ (int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) / 60 }}
                                            hour
                                        </td>
                                        @elseif(((int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) / 60) > 1)
                                            <td
                                                class="border border-gray-300 px-4 py-2 lg:text-base sm:text-sm text-[10px]">
                                                {{ floor((int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) / 60) }}
                                                hours
                                                {{ round((int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) % 60) }}
                                                minutes
                                            </td>
                                                @endif
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="text-center">
                                        <td colspan="4"
                                            class="border border-gray-300 px-4 py-2 lg:text-base sm:text-sm text-[10px]">
                                            No records
                                            found
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </section>

                </div>
            </div>

        </div>
    </main>
</x-main-layout>
<script>
    let month = document.querySelector("[name='monthValue']").value;
    let year = document.querySelector("[name='yearValue']").value;
    let toUserId = document.querySelector("[name='toUserValue']").value;
    let requestId = document.querySelector("[name='requestId']").value;
    let count = 0;

    function requestPDF() {

        var user_id = "{{ auth()->id() }}"; // Get logged-in user's ID

        if (count >= 1) {
            toastr.error(`Please wait for 30 seconds to send request again!`);

            setTimeout(function() {
                count = 0;
            }, 30000);
        } else {
            fetch("{{ route('user.send.request.download.notification') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}" // CSRF protection
                    },
                    body: JSON.stringify({
                        role: 'admin',
                        to_user_id: 1,
                        month: month,
                        year: year,
                    })
                })
                .then(response => response.status)
                .then(data => {
                    if (data === 200) {
                        toastr.success("Download request has been sent!");
                    } else {
                        toastr.error("Failed to generate PDF.");
                    }
                })
                .catch(error => console.error("Error:", error));

        }
        count++;
    }

    document.addEventListener("DOMContentLoaded", function () {
    // Approve Button
    document.querySelector(".approve-btn").addEventListener("click", function () {
        handleAction("approve");
    });

    // Decline Button
    document.querySelector(".decline-btn").addEventListener("click", function () {
        handleAction("decline");
    });

    function handleAction(action) {

        let app_url = `{{ url('/admin-dtr-${action}') }}`;

        fetch(app_url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({ 
                id: requestId,
                to_user_id: toUserId,
                from_user_id: 1,
                month: month,
                year: year, 
            })
        })
        .then(response => {
            if (response.status === 200) {
                toastr.success(`Request successfully ${action}d`);
                location.reload(); // Reload page to reflect changes
            } else {
                alert(`Failed to ${action} request.`);
            }
        })
        .catch(error => console.error("Error:", error));
    }
});
</script>