<x-main-layout>
    <x-modal.dtr-summary id="dtr-summary-modal" :yearlyTotals="$yearlyTotals" />

    <main class="w-full">
        {{-- <x-modal.dtr-summary id="dtr-summary-modal" /> --}}
        <div class="flex flex-col gap-5 w-full items-center justify-center pb-5">
            <div
                class="w-full grid xl:!grid-cols-3 text-nowrap grid-cols-2 gap-5 bg-white p-3 border border-gray-200 shadow-lg sticky top-5 z-30 rounded-full max-w-screen-xl mx-auto">

                <section class="xl:col-span-1 xl:flex justify-start items-center hidden w-full">
                    <form action="{{ route('users.dtr.post') }}" method="POST" class="inline">
                        @csrf
                        @method('POST')
                        <input type="month" name="searchDate" id="searchDate"
                            class="px-5 py-2 rounded-full cursor-pointer border border-gray-200 text-sm"
                            value="{{ \Carbon\Carbon::parse($pagination['currentMonth']['name'])->format('Y-m') }}"
                            onchange="this.form.submit()">
                    </form>
                </section>

                <section class="flex items-center gap-3 col-span-1 xl:!justify-center justify-start w-full">
                    <form action="{{ route('users.dtr.post') }}" method="POST" class="inline">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="month" value="{{ $pagination['previousMonth']['month'] }}">
                        <input type="hidden" name="year" value="{{ $pagination['previousMonth']['year'] }}">
                        <button type="submit"
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center text-sm">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            <span
                                class="sm:block hidden">{{ \Carbon\Carbon::parse($pagination['previousMonth']['name'])->format('M Y') }}</span>
                        </button>
                    </form>
                    <form action="{{ route('users.dtr.post') }}" method="POST" class="inline">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="month" value="{{ $pagination['nextMonth']['month'] }}">
                        <input type="hidden" name="year" value="{{ $pagination['nextMonth']['year'] }}">
                        <button type="submit"
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center text-sm">
                            <span
                                class="sm:block hidden">{{ \Carbon\Carbon::parse($pagination['nextMonth']['name'])->format('M Y') }}</span>
                            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </form>
                </section>

                <section class="flex items-center gap-3 col-span-1 justify-end w-full h-auto">
                    <!-- Fix alignment and padding for DTR Summary -->
                    <x-button tertiary label="DTR Summary" openModal="dtr-summary-modal"
                        className="text-xs lg:px-8 px-4 !py-4 modal-button" />
                
                    <!-- Request PDF Button (With onClick Event) -->
                    <x-button primary label="Request a PDF" showLabel="{{ true }}"
                        leftIcon="ph--hand-deposit lg:!w-6 lg:!h-6 !w-4 !h-4" className="text-xs lg:px-8 px-4"
                        onClick="requestPDF()" />
                </section>
            </div>

            <div class="xl:w-[75%] lg:w-[85%] md:w-[95%] w-[100%] h-auto mt-8">
                <div
                    class="w-auto h-auto border bg-white border-gray-100 shadow-md resize-none p-8 space-y-5 select-none">
                    <section class="flex items-start justify-between">
                        <x-logo width="lg:w-[200px] w-[150px]" />
                        <x-image path="{{\App\Models\File::where('id', Auth::user()->schools->file_id)->first()->path}}" className="lg:w-16 w-12 h-auto" />
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
                                    class="font-normal lg:text-base text-sm">{{ floor((int) filter_var($totalHoursPerMonth, FILTER_SANITIZE_NUMBER_INT) / 60) }} hours {{ round(((int) filter_var($totalHoursPerMonth, FILTER_SANITIZE_NUMBER_INT) % 60)) }} minutes</span></p>
                        </div>
                    </section>

                    <input type="text" name='monthValue' class="hidden" value="{{$pagination['currentMonth']['month']}}" />
                    <input type="text" name='yearValue' class="hidden" value="{{$pagination['currentMonth']['year']}}" />

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
                                            @if (((int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) / 60) < 1)
                                            <td
                                            class="border border-gray-300 px-4 py-2 lg:text-base sm:text-sm text-[10px]">
                                            {{ (int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) }} minutes
                                        </td>
                                        @elseif(((int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) / 60) == 1)
                                        <td
                                        class="border border-gray-300 px-4 py-2 lg:text-base sm:text-sm text-[10px]">
                                        {{ ((int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) / 60) }} hour</td>
                                        @elseif(((int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) / 60) > 1)
                                                    <td
                                                        class="border border-gray-300 px-4 py-2 lg:text-base sm:text-sm text-[10px]">
                                                        {{ floor((int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) / 60) }} hours {{ round(((int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) % 60)) }} minutes
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
    let count = 0;

    console.log(month, year);

    function requestPDF() {
        console.log(month, year);

        var user_id = "{{ auth()->id() }}"; // Get logged-in user's ID

        if(count >= 1){
            toastr.error(`Please wait for 30 seconds to send request again!`);
            console.log(count);
            setTimeout(function(){
                count = 0;
            }, 30000);
        }else{
            fetch("{{ route('user.send.request.download.notification') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}" // CSRF protection
                },
                body: JSON.stringify({
                    to_user_role: 'admin',
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

</script>