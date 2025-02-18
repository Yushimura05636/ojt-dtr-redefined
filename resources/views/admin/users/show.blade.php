<x-main-layout>
    <div class="h-auto w-full flex flex-col gap-6">
        {{-- <section class="flex items-center justify-between gap-5">
            <x-button routePath="admin.users" label="Back" tertiary button showLabel="{{ true }}"
                leftIcon="eva--arrow-back-fill" className="lg:px-8 px-3" />
            <div class="flex items-center gap-2">
                <x-button tertiary label="View DTR" routePath="admin.users.dtr" :params="['id' => $user->id]" button
                    className="px-8 font-semibold" />
                <x-button primary label="Edit User" button className="px-8" routePath="admin.users.details.edit"
                    :params="['id' => $user->id]" />
            </div>
        </section> --}}

        <section
            class="w-full flex items-center justify-between gap-5 bg-white p-3 border border-gray-200 shadow-lg sticky top-[125px] z-30 rounded-full">
            <x-button routePath="admin.users" label="Back" tertiary button showLabel="{{ true }}"
                leftIcon="eva--arrow-back-fill" className="lg:px-8 px-3" />
            <div class="flex items-center gap-2">
                <x-button tertiary label="View DTR" routePath="admin.users.dtr" :params="['id' => $user->id]" button
                    className="px-8 font-semibold" />
                <x-button primary label="Edit User" button className="px-8" routePath="admin.users.details.edit"
                    :params="['id' => $user->id]" />
            </div>
        </section>

        <section class="rounded-lg p-7 border border-gray-200 bg-white h-auto w-full flex flex-col gap-5">

            <div class="w-full">
                <div class="w-auto h-auto flex flex-col gap-3 items-center justify-center mb-5">
                    <x-image
                        className="lg:!w-80 md:!w-60 w-40 lg:!h-80 md:!h-60 h-40 rounded-full border border-[#F57D11] lg:!mx-0 mx-auto"
                        path="resources/img/default-male.png" />
                    <h1 class="capitalize font-semibold text-lg">{{ $user->firstname }}
                        {{ substr($user->middlename, 0, 1) }}. {{ $user->lastname }}</h1>
                </div>

                <div class="space-y-2">
                    <x-form.section-title title="User Details" vectorClass="!h-3" />
                    <section class="flex items-start gap-x-2">
                        <div class="text-sm font-semibold text-gray-700">Gender:</div>
                        <p class="text-base -mt-[3px] capitalize">{{ $user->gender }}</p>
                    </section>
                    <section class="flex items-start gap-x-2">
                        <div class="text-sm font-semibold text-gray-700">Email:</div>
                        <p class="text-base -mt-[3px]">{{ $user->email }}</p>
                    </section>
                    <section class="flex items-start gap-x-2">
                        <div class="text-sm font-semibold text-gray-700">Phone No:</div>
                        <p class="text-base -mt-[3px]">{{ $user->phone }}</p>
                    </section>
                    <section class="flex items-start gap-x-2">
                        <div class="text-sm font-semibold text-gray-600">Address:</div>
                        <p class="text-base -mt-[3px]">{{ $user->address }}</p>
                    </section>
                    <section class="flex items-start gap-x-2">
                        <div class="text-sm font-semibold text-gray-600">School:</div>
                        <p class="text-base -mt-[3px]">{{ $user->school }}</p>
                    </section>
                </div>
            </div>

            <hr>

            <div class="space-y-2">
                <x-form.section-title title="Emergency Contact" vectorClass="!h-3" />
                <section class="flex items-start gap-x-2">
                    <div class="text-sm font-semibold text-gray-700">Name:</div>
                    <p class="text-base -mt-[3px]">{{ $user->emergency_contact_fullname }}</p>
                </section>
                <section class="flex items-start gap-x-2">
                    <div class="text-sm font-semibold text-gray-700">Address:</div>
                    <p class="text-base -mt-[3px]">{{ $user->emergency_contact_address }}</p>
                </section>
                <section class="flex items-start gap-x-2">
                    <div class="text-sm font-semibold text-gray-700">Contact No:</div>
                    <p class="text-base -mt-[3px]">{{ $user->emergency_contact_number }}</p>
                </section>
            </div>

            <hr>

            <div class="space-y-2">
                <x-form.section-title title="Account Status" vectorClass="!h-3" />
                <section class="flex items-start gap-x-2">
                    <div class="text-sm font-semibold text-gray-700">Account Started:</div>
                    <p class="text-base -mt-[3px]">{{ $user->starting_date }}</p>
                </section>
                <section class="flex items-start gap-x-2">
                    <div class="text-sm font-semibold text-gray-700">Account Expiration:</div>
                    <p class="text-base -mt-[3px]">{{ $user->expiry_date }}</p>
                </section>
            </div>
        </section>

        <section class="h-auto w-full border border-gray-200 rounded-lg">
            <div
                class="flex items-center gap-1 px-7 py-5 bg-gradient-to-r from-[#F57D11] via-[#F57D11]/90 to-[#F53C11] rounded-t-lg text-white shadow-md w-full">
                <span class="material-symbols--history-rounded w-6 h-6"></span>
                <h1 class="font-semibold">Logged History</h1>
            </div>

            @php
                // $histories = [
                //     ['description' => 'time in', 'timeFormat' => '2025-02-05 08:48:35', 'datetime' => '2025-02-05'],
                //     ['description' => 'time in', 'timeFormat' => '2025-02-05 08:48:35', 'datetime' => '2025-02-05'],
                //     ['description' => 'time in', 'timeFormat' => '2025-02-05 08:48:35', 'datetime' => '2025-02-05'],
                //     ['description' => 'time in', 'timeFormat' => '2025-02-05 08:48:35', 'datetime' => '2025-02-05'],
                //     ['description' => 'time in', 'timeFormat' => '2025-02-05 08:48:35', 'datetime' => '2025-02-05'],
                //     ['description' => 'time in', 'timeFormat' => '2025-02-05 08:48:35', 'datetime' => '2025-02-05'],
                // ];
            @endphp

            <div class="h-60 w-full bg-white overflow-auto rounded-b-lg">
                <div class="text-black flex flex-col h-full items-start justify-start">
                    @forelse ($histories as $history)
                        <section
                            class="px-7 py-5 w-full h-fit border-b border-gray-200 hover:bg-gray-100 flex flex-wrap gap-2 justify-between items-center">
                            <div>
                                <section class="font-bold">{{ $history['timeFormat'] ?? 'N/A' }}</section>
                                <p class="text-sm font-medium text-gray-700">
                                    {{ $history['datetime'] ?? 'No date available' }}
                                </p>
                            </div>
                            @if (!empty($history['description']) && $history['description'] === 'time in')
                                <div class="text-green-500 flex items-center gap-1 select-none text-sm font-semibold">
                                    <p>Time in</p>
                                </div>
                            @else
                                <div class="text-red-500 flex items-center gap-1 select-none text-sm font-semibold">
                                    <p>Time out</p>
                                </div>
                            @endif
                        </section>
                    @empty
                        <div class=" h-full w-full flex items-center justify-center ">
                            <p class="text-center font-semibold text-gray-600">
                                User has no logged history.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </section>
    </div>
</x-main-layout>
