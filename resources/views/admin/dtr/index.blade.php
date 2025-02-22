{{-- <x-main-layout :array_daily="$array_daily" :ranking="$ranking">
    dtr
</x-main-layout> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">DTR Summary</h2>
                        
                        <!-- Month Navigation -->
                        <div class="flex gap-2">
                            <select id="monthSelector" class="rounded border-gray-300 shadow-sm">
                                @foreach(array_keys($allMonthsData) as $index => $monthKey)
                                    <option value="month-{{ $index }}">
                                        {{ $allMonthsData[$monthKey]['month_name'] }}
                                    </option>
                                @endforeach
                            </select>
                            <button onclick="showAllMonths()" class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200">
                                Show All
                            </button>
                        </div>
                    </div>

                    @foreach($allMonthsData as $monthKey => $monthData)
                        <div id="month-{{ $loop->index }}" class="month-section mb-12 border-b pb-8">
                            <h2 class="text-2xl font-bold mb-6 bg-gray-50 p-4 rounded sticky top-0">
                                {{ $monthData['month_name'] }}
                            </h2>

                            @foreach($monthData['users'] as $userData)
                                <div class="mb-8">
                                    <h3 class="text-xl font-bold mb-4 bg-gray-100 p-4 rounded">
                                        {{ $userData['user']->firstname }} {{ $userData['user']->lastname }}
                                        <span class="text-gray-600 text-sm ml-2">({{ $userData['user']->email }})</span>
                                        <span class="float-right">Total Hours: {{ $userData['total_hours'] }}</span>
                                    </h3>

                                    <div class="overflow-x-auto">
                                        <table class="min-w-full bg-white">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time In</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Out</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hours Worked</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($userData['records'] as $date => $record)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="text-green-600">{{ $record['time_in'] }}</span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="text-red-600">{{ $record['time_out'] }}</span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            {{ ((int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT)) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        // Hide all months initially except the first one
        document.addEventListener('DOMContentLoaded', function() {
            const monthSections = document.querySelectorAll('.month-section');
            monthSections.forEach((section, index) => {
                if (index !== 0) {
                    section.style.display = 'none';
                }
            });
        });

        // Month selector functionality
        document.getElementById('monthSelector').addEventListener('change', function() {
            const selectedMonth = this.value;
            const monthSections = document.querySelectorAll('.month-section');
            
            monthSections.forEach(section => {
                section.style.display = 'none';
            });
            
            document.getElementById(selectedMonth).style.display = 'block';
        });

        // Show all months functionality
        function showAllMonths() {
            const monthSections = document.querySelectorAll('.month-section');
            monthSections.forEach(section => {
                section.style.display = 'block';
            });
        }
    </script>
