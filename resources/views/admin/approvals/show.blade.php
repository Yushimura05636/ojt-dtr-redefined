
<x-main-layout>
    <main class="w-full">
        {{-- <x-modal.dtr-summary id="dtr-summary-modal" /> --}}
        <div class="flex flex-col gap-5 w-full items-center justify-center pb-5">
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
                                            {{ round(((int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) % 60)) }} minutes
                                        </td>
                                        @elseif(((int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) / 60) == 1)
                                        <td
                                        class="border border-gray-300 px-4 py-2 lg:text-base sm:text-sm text-[10px]">
                                        {{ floor((int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) / 60) }} hours {{ round(((int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) % 60)) }} minutes</td>
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
