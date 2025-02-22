{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook-like Layout</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 overflow-hidden"> <!-- Prevents outer scrollbar -->

    <!-- Navbar (Sticky at the Top) -->
    <nav class="bg-white shadow-md fixed top-0 left-0 w-full z-50">
        <div class="max-w-screen-xl mx-auto flex justify-between items-center p-4">
            <h1 class="text-xl font-semibold">Logo</h1>
            <button id="menu-toggle" class="lg:hidden p-2 border rounded-md">
                ☰
            </button>
        </div>
    </nav>

    <!-- Sidebar Menu (Hidden on Large Screens) -->
    <aside id="mobile-menu"
        class="fixed top-14 left-0 w-64 h-screen mt-5 bg-white shadow-md p-5 transform -translate-x-full transition-transform lg:hidden overflow-auto">
        <ul class="space-y-4 ">
            @for ($i = 1; $i <= 7; $i++)
                <li><a href="#" class="block p-3 rounded-md hover:bg-gray-200">Home</a></li>
                <li><a href="#" class="block p-3 rounded-md hover:bg-gray-200">Friends</a></li>
                <li><a href="#" class="block p-3 rounded-md hover:bg-gray-200">Groups</a></li>
            @endfor
        </ul>
    </aside>

    <div class="mt-16 h-[calc(100vh-4rem)] w-full grid grid-cols-1 lg:grid-cols-12">
        <!-- Left Sidebar (Sticky on Large Screens) -->
        <aside
            class="hidden lg:block lg:col-span-3 xl:col-span-2 bg-white shadow-md p-5 rounded-lg sticky top-16 h-[calc(100vh-4rem)] overflow-auto">
            <ul class="space-y-4">
                @for ($i = 1; $i <= 7; $i++)
                    <li><a href="#" class="block p-3 rounded-md hover:bg-gray-200">Home</a></li>
                    <li><a href="#" class="block p-3 rounded-md hover:bg-gray-200">Friends</a></li>
                    <li><a href="#" class="block p-3 rounded-md hover:bg-gray-200">Groups</a></li>
                @endfor
            </ul>
        </aside>

        <!-- Main Content (Auto Scroll) -->
        <main class="col-span-12 lg:col-span-6 xl:col-span-8 overflow-auto p-5 h-[calc(100vh-4rem)]">
            <div class="max-w-2xl mx-auto space-y-5">
                @for ($i = 1; $i <= 20; $i++)
                    <div class="bg-white p-5 rounded-lg shadow-md">Post {{ $i }}</div>
                @endfor
            </div>
        </main>

        <!-- Right Sidebar (Sticky on Large Screens) -->
        <aside
            class="hidden lg:block lg:col-span-3 xl:col-span-2 bg-white shadow-md p-5 rounded-lg sticky top-16 h-[calc(100vh-4rem)] overflow-auto">
            <h1 class="font-semibold text-lg">Trending</h1>
            <ul class="mt-4 space-y-3">
                <li><a href="#" class="block p-3 rounded-md hover:bg-gray-200">News 1</a></li>
                <li><a href="#" class="block p-3 rounded-md hover:bg-gray-200">News 2</a></li>
                <li><a href="#" class="block p-3 rounded-md hover:bg-gray-200">News 3</a></li>
            </ul>
        </aside>

    </div>

    <!-- JavaScript for Hamburger Menu -->
    <script>
        const menuToggle = document.getElementById("menu-toggle");
        const mobileMenu = document.getElementById("mobile-menu");

        menuToggle.addEventListener("click", () => {
            mobileMenu.classList.toggle("-translate-x-full");
        });
    </script>

</body>

</html> --}}


<x-main-layout>
    <main class="container mx-auto h-full max-w-screen-xl">
        <div class="h-auto w-full flex items-center justify-center py-20">
            <div class="space-y-7 w-1/2 ">
                <div class="w-full flex flex-wrap items-end justify-between gap-5">
                    <section>
                        Pagination
                    </section>
                    <section class="flex items-center gap-3">
                        <x-button tertiary label="DTR Summary" button className="text-xs px-8" />
                        <x-button primary label="Download PDF" button className="text-xs px-8" routeName='{{ route('download.pdf', ['records' => $records, 'pagination ' => $pagination, 'totalHoursPerMonth' => $totalHoursPerMonth]) }}'" />
                    </section>
                </div>

                {{-- download this --}}
                <div class="w-auto h-auto border border-gray-100 shadow-md resize-none p-8 space-y-5 select-none">
                    <section class="flex items-start justify-between">
                        <x-logo />
                        <x-image path="resources/img/school-logo/sti.png" className="w-16 h-auto" />
                    </section>
                    <section class="my-7 text-center">
                        <p class="text-custom-orange font-semibold">OJT Daily Time Record</p>
                        <h1 class="text-xl mt-2">FEBRUARY 2025</h1>
                    </section>
                    <hr>
                    <section class="space-y-2">
                        <p class="text-sm font-semibold">Name: <span class="font-normal text-base">Full Name</span></p>
                        <p class="text-sm font-semibold">Position: <span class="font-normal text-base">Intern</span></p>
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm font-semibold">Hours This Month: <span class="font-normal text-base">69
                                    Hours</span></p>
                            <p class="text-sm font-semibold">Approved By: <span
                                    class="font-normal">__________________</span></p>
                        </div>
                    </section>

                    <section class="h-auto w-full border border-gray-200 overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th
                                        class="border text-sm text-white bg-custom-orange border-custom-orange/80 px-4 py-2">
                                        Day
                                    </th>
                                    <th
                                        class="border text-sm text-white bg-custom-orange border-custom-orange/80 px-4 py-2">
                                        Time In</th>
                                    <th
                                        class="border text-sm text-white bg-custom-orange border-custom-orange/80 px-4 py-2">
                                        Time Out
                                    </th>
                                    <th
                                        class="border text-sm text-white bg-custom-orange border-custom-orange/80 px-4 py-2">
                                        Total Hours
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($day = 1; $day <= 28; $day++)
                                    <tr class="text-center">
                                        <td class="border border-gray-300 px-4 py-2">{{ $day }}</td>
                                        <td class="border border-gray-300 px-4 py-2">8:00 AM</td>
                                        <td class="border border-gray-300 px-4 py-2">6:00 PM</td>
                                        <td class="border border-gray-300 px-4 py-2">8 Hours</td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </section>

                </div>

                {{-- end of download --}}
            </div>
        </div>
    </main>

</x-main-layout>
