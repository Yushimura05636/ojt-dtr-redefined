d<x-main-layout>
    {{-- <main class="flex flex-col gap-5 justify-center items-center pt-[8rem]">
        <x-button primary label="Back" routePath="users.dtr" className="text-xs px-8" />
        
    </main> --}}

    {{-- <main class="lg:container max-w-screen-xl mx-auto">
        <section class="w-full lg:h-[calc(100vh-7rem)] h-[calc(100vh-4rem)] overflow-auto lg:p-10 p-5">
            <div class=" bg-white shadow-md rounded-lg p-4 w-full max-w-3xl border">
                <div class="flex items-start space-x-6 border-b pb-4">
                    <img src="{{ $profile_image ?? 'https://via.placeholder.com/100' }}" alt="Profile Image"
                        class="w-24 h-24 rounded-full border">
                    <div class="flex-1 grid grid-cols-3 gap-x-4 gap-y-1 text-sm">
                        <span class="font-semibold">Full Name</span> <span class="col-span-2">: {{ $user->firstname }}
                            {{ $user->lastname }}</span>
                        <span class="font-semibold">Email</span> <span class="col-span-2">: {{ $user->email }}</span>
                        <span class="font-semibold">Phone</span> <span class="col-span-2">: {{ $user->phone }}</span>
                        <span class="font-semibold">School ID</span> <span class="col-span-2">:
                            {{ $user->student_no }}</span>

                        <span class="font-semibold">Address</span> <span class="col-span-2">:
                            {{ $user->address }}</span>
                        <span class="font-semibold">Gender</span> <span class="col-span-2">: {{ $user->gender }}</span>
                        <span class="font-semibold">Date Started</span> <span class="col-span-2">:
                            {{ $user->starting_date }}</span>

                        <span class="font-semibold">E-Name</span> <span class="col-span-2">:
                            {{ $user->emergency_contact_fullname }}</span>
                        <span class="font-semibold">E-Contact</span> <span class="col-span-2">:
                            {{ $user->emergency_contact_number }}</span>
                        <span class="font-semibold">E-Address</span> <span class="col-span-2">:
                            {{ $user->emergency_contact_address }}</span>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-4">Yearly Hours Summary</h3>
                    <div class="overflow-x-auto">
                        @php $totalHoursOverall = 0; @endphp
                        @foreach ($yearlyTotals as $yearData)
                            @php $totalHoursOverall += $yearData['total_hours']; @endphp

                            <div class="mb-8">
                                <h4 class="text-md font-semibold bg-gray-100 p-3 rounded">
                                    Year {{ $yearData['year'] }}
                                    <span class="float-right">Total: {{ $yearData['total_hours'] }} hrs</span>
                                </h4>

                                <table class="w-full text-left text-sm mt-2">
                                    <thead class="bg-gray-50">
                                        <tr>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($yearData['months'] as $monthData)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-3">{{ $monthData['month_name'] }}</td>
                                                <td class="px-4 py-3 text-right">{{ $monthData['total_hours'] }} hrs
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach

                        <div class="mt-6 border-t pt-4">
                            <div class="text-lg font-semibold flex justify-between">
                                <span>Total Overall Hours</span>
                                <span>{{ $totalHoursOverall }} hrs</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main> --}}

    <main class="h-auto w-full">
        <div class="flex flex-col gap-5 items-center justify-center w-full">
            <div class="flex justify-between items-center w-full  max-w-3xl ">
                <h1 class="text-lg text-custom-red font-bold">DTR Summary</h1>
                <x-button primary label="Back" leftIcon="eva--arrow-back-fill" routePath="users.dtr"
                    className="text-xs px-8" />
            </div>
            <div class=" bg-white shadow-md rounded-lg p-4 w-full max-w-3xl border">
                {{-- <div class="flex items-start space-x-6 border-b pb-4">
                        <img src="{{ $profile_image ?? 'https://via.placeholder.com/100' }}" alt="Profile Image"
                            class="w-24 h-24 rounded-full border">
                        <div class="flex-1 grid grid-cols-3 gap-x-4 gap-y-1 text-sm">
                            <span class="font-semibold">Full Name</span> <span class="col-span-2">:
                                {{ $user->firstname }}
                                {{ $user->lastname }}</span>
                            <span class="font-semibold">Email</span> <span class="col-span-2">:
                                {{ $user->email }}</span>
                            <span class="font-semibold">Phone</span> <span class="col-span-2">:
                                {{ $user->phone }}</span>
                            <span class="font-semibold">School ID</span> <span class="col-span-2">:
                                {{ $user->student_no }}</span>

                            <span class="font-semibold">Address</span> <span class="col-span-2">:
                                {{ $user->address }}</span>
                            <span class="font-semibold">Gender</span> <span class="col-span-2">:
                                {{ $user->gender }}</span>
                            <span class="font-semibold">Date Started</span> <span class="col-span-2">:
                                {{ $user->starting_date }}</span>

                            <span class="font-semibold">E-Name</span> <span class="col-span-2">:
                                {{ $user->emergency_contact_fullname }}</span>
                            <span class="font-semibold">E-Contact</span> <span class="col-span-2">:
                                {{ $user->emergency_contact_number }}</span>
                            <span class="font-semibold">E-Address</span> <span class="col-span-2">:
                                {{ $user->emergency_contact_address }}</span>
                        </div>
                    </div> --}}

                <div>
                    <div class="overflow-x-auto">
                        @php $totalHoursOverall = 0; @endphp
                        @foreach ($yearlyTotals as $yearData)
                            @php $totalHoursOverall += $yearData['total_hours']; @endphp

                            <div class="mb-8">
                                <h4 class="text-md font-semibold bg-gray-100 p-3 rounded">
                                    Year {{ $yearData['year'] }}
                                    <span class="float-right">Total: {{ ((int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT) / 60) }} hrs</span>
                                </h4>

                                <table class="w-full text-left text-sm mt-2">
                                    <thead class="bg-gray-50">
                                        <tr>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($yearData['months'] as $monthData)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-3">{{ $monthData['month_name'] }}</td>
                                                <td class="px-4 py-3 text-right">{{ $monthData['total_hours'] }}
                                                    hrs
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach

                        <div class="mt-6 border-t pt-4">
                            <div class="text-lg font-semibold flex justify-between text-custom-red">
                                <span>Total Overall Hours hasjkdhakjsdj </span>
                                <span>{{ ((int) filter_var($totalHoursOverall, FILTER_SANITIZE_NUMBER_INT) / 60) }} hrs</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-main-layout>
