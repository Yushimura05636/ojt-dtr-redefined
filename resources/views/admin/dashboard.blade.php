{{-- scanner modal --}}
{{-- <x-modal.scanner id="scanner-modal" /> --}}

{{-- time in modal --}}
<meta name="app-url" content="{{ config('app.url') }}">


<!-- HTML5 QR Code Scanner -->
<script src="https://unpkg.com/html5-qrcode"></script>

<link rel="stylesheet" href="../resources/css/app.css">
    <script src="../resources/js/app.js"></script>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">

<!-- Camera -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>

<!-- Include Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

<!-- Include jQuery (required for Toastr) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Include Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


{{-- @if (session('success'))
    <x-modal.flash-msg msg="success" />
@elseif ($errors->has('invalid'))
    <x-modal.flash-msg msg="invalid" />
@elseif (session('invalid'))
    <x-modal.flash-msg msg="invalid" />
@endif --}}

<!-- Check if there is a toast session message -->
@if (session('toast'))
    <script>
        // Show the Toastr notification based on the session data
        var toastData = @json(session('toast'));

        // Customize the options for Toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000", // The message will stay for 5 seconds
        };

        // Display the message
        if (toastData.status == 'success') {
            toastr.success(toastData.message); // Display success toast
        } else if (toastData.status == 'error') {
            toastr.error(toastData.message); // Display error toast
        }
    </script>
@endif


<x-main-layout :array_daily="$array_daily" :ranking="$ranking">
    <x-modal.time-in-time-out-modal id="time-in-time-out-modal" />

    {{-- <span name="time_in_success" id="time_in_success" class="hidden">
    <x-flash-msg msg="Time In checked successfully"/>
    </span>
    <span name="time_out_success" id="time_out_success" class="hidden">
    <x-flash-msg msg="Time Out checked successfully"/>
    </span> --}}

    <div class="flex flex-col gap-5 w-auto h-auto">

        <div class="h-full w-full">
            <section class="h-full w-full p-7 border bg-white rounded-xl border-gray-200">
                <!-- Scanner Section -->
                <div id="reader" class="h-full w-full"></div>
            </section>


        </div>

        <div class="flex lg:flex-row flex-col lg:gap-7 gap-5 w-full lg:!h-[500px] h-[600px]">
            <section
                class="p-7 w-full border bg-white border-gray-200 rounded-xl h-full overflow-hidden flex flex-col gap-5">
                <div
                    class="flex lg:items-end items-center flex-wrap gap-2 text-[#F53C11] justify-between w-full font-semibold">
                    <div class="flex lg:items-start items-center gap-2">
                        <span class="material-symbols--co-present-outline"></span>
                        <p class="font-semibold lg:!text-lg text-sm">Daily Attendance</p>
                    </div>

                    <div class="md:!text-sm text-xs font-semibold">
                        {{ \Carbon\Carbon::now()->format('M d, Y') }}</div>
                </div>
                <div class="h-full pb-7 w-full bg-white overflow-y-auto border border-gray-100 rounded-md">
                    @forelse ($array_daily as $daily)
                        <a href="{{ route('admin.users.details', ['id' => $daily['id']]) }}"
                            class="px-7 py-5 w-full flex flex-wrap justify-between border-b border-gray-200 bg-white hover:bg-gray-100 items-center cursor-pointer">
                            <div class="flex items-start gap-5 w-full">
                                <x-image className="w-12 h-12 rounded-full border border-[#F57D11]"
                                    path="{{
                                        \App\Models\File::where('id', $daily['profiles']['file_id'])->first()->path . '?t=' . time()
                                    }}" />
                                <div class="flex items-center flex-wrap justify-between w-full gap-x-2">
                                    <div class="w-1/2 ">
                                        <section class="font-bold text-black text-lg truncate">
                                            {{ $daily['timeFormat'] }}
                                        </section>
                                        <p class="text-sm font-medium text-gray-700 capitalize truncate">
                                            {{ $daily['name'] }}</p>
                                    </div>
                                    @if ($daily['description'] === 'time in')
    <div class="flex items-center gap-1 select-none text-sm font-semibold">
        <p class="{{ $daily['extra_description'] === 'late' ? 'text-red-500 font-bold' : 'text-green-500' }}">
            Time in{{ $daily['extra_description'] === 'late' ? ' | Late' : '' }}
        </p>
    </div>
@else
    <div class="text-red-500 flex items-center gap-1 select-none text-sm font-semibold">
        <p>Time out</p>
    </div>
@endif

                                </div>
                            </div>
                        </a>
                    @empty
                        <h1 class="text-center flex items-center justify-center h-full font-semibold text-gray-500">
                            Waiting for attendees...
                        </h1>
                    @endforelse
                </div>
            </section>

            <section
                class="p-7 rounded-xl border border-gray-200 bg-white h-full w-full overflow-hidden flex flex-col gap-5">
                <div
                    class="flex lg:items-end items-center flex-wrap gap-2 text-[#F53C11] justify-between w-full font-semibold">
                    <div class="flex lg:items-start items-center gap-2">
                        <span class="hugeicons--champion"></span>
                        <p class="font-semibold lg:!text-lg text-sm">Top 3 Performer</p>
                    </div>
                    <p class="md:!text-sm text-xs font-semibold">Highest Hour Basis</p>
                </div>

                <!--HTML CODE-->
                <div class="w-full relative h-full">
                    <div class="swiper progress-slide-carousel swiper-container h-full flex">
                        <div class="swiper-wrapper h-full flex">
                            @forelse ($ranking as $index => $user)
                                @if ($user['role'] != 'admin' && $user['hours_worked'] > 0)
                                    <div class="swiper-slide h-full flex">
                                        <div
                                            class="bg-[#F57D11]/5 h-full w-full overflow-hidden flex flex-col justify-center">
                                            <section class="flex items-end text-center gap-2 w-full p-5 relative h-full">
                                                <div class="w-full space-y-1 px-5">
                                                    <p class="text-sm font-semibold">TOP {{ $index + 1 }}</p>
                                                    <h1 class="text-sm truncate capitalize text-gray-500/80">
                                                        {{ $user['name'] }}
                                                    </h1>
                                                    <p class="text-xl font-semibold text-[#F57D11]">
                                                        {{ $user['hours_worked'] }} hours
                                                    </p>
                                                </div>
                                                <x-image path="{{
                                                    \App\Models\File::where('id', $user['profiles']['file_id'])->first()->path . '?t=' . time()
                                                }}"
                                                    className="absolute inset-0 mx-auto h-full scale-125 w-auto opacity-20 z-0" />
                                            </section>
                                        </div>
                                    </div>
                                @elseif ($index > 0 && $user['hours_worked'] > 0)
                                    <div class="swiper-slide h-full flex">
                                        <div
                                            class="bg-[#F57D11]/5 h-full w-full overflow-hidden flex flex-col justify-center">
                                            <section class="flex items-end text-center gap-2 w-full p-5 relative h-full">
                                                <div class="w-full space-y-1 px-5">
                                                    <p class="text-sm font-semibold">TOP {{ $index + 2 }}</p>
                                                    <h1 class="text-sm truncate capitalize text-gray-500/80">
                                                        ???
                                                    </h1>
                                                    <p class="text-xl font-semibold text-[#F57D11]">
                                                        ???
                                                    </p>
                                                </div>
                                                <x-image path="{{
                                                    optional(\App\Models\File::find(id: $user['profiles']['file_id']))->path . '?t=' . time()
                                                    ?? 'resources/img/default-male.png'
                                                }}"
                                                    className="absolute inset-0 mx-auto h-full scale-125 w-auto opacity-20 z-0" />
                                            </section>
                                        </div>
                                    </div>
                                @elseif ($index <= 0)
                                    <div class="flex w-full items-center justify-center h-full font-semibold text-gray-500">
                                        No top performer yet.
                                    </div>
                                @endif
                            @empty
                                <div class="flex w-full items-center justify-center h-full font-semibold text-gray-500">
                                    No top performer yet.
                                </div>
                            @endforelse
                        </div>
                        <div class="swiper-pagination !bottom-0 !top-auto mx-auto bg-gray-100"></div>
                    </div>
                </div>

            </section>
        </div>

        @php
            $totals = [
                ['label' => 'Total Scans', 'number' => $totalScans],
                ['label' => 'Total Registered', 'number' => $totalRegister],
                ['label' => 'Time In', 'number' => $totalTimeIn],
                ['label' => 'Time Out', 'number' => $totalTimeOut],
            ];
        @endphp

        <div class="grid grid-cols-2 gap-5 w-full h-auto">
            @foreach ($totals as $total)
                <section class="p-7 w-full flex justify-between h-full border bg-white border-gray-200 rounded-xl">
                    <h1 class="font-semibold text-sm">{{ $total['label'] }}</h1>
                    <p class="font-bold text-xl text-[#F53C11]">{{ $total['number'] }}</p>
                </section>
            @endforeach
        </div>

        <div class="w-full h-full">
            <section class="p-7 w-full border bg-white border-gray-200 rounded-xl h-[500px] flex flex-col gap-5">
                <div class="flex items-center gap-2 text-[#F53C11] font-semibold">
                    <span class="cuida--user-add-outline"></span>
                    <p class="font-semibold text-lg">Recently Added Users</p>
                </div>
                <div class="h-full w-full bg-white overflow-y-auto border border-gray-100 rounded-md">
                    @forelse ($recentlyAddedUser as $index => $user)
                        @if ($user['role'] != 'admin')
                            <a href="{{ route('admin.users.details', ['id' => $user['id']]) }}"
                                class="px-7 py-5 w-full flex justify-between items-center border-b border-gray-200 hover:bg-gray-100 cursor-pointer">
                                <div class="flex items-center gap-5 w-1/2">
                                    <x-image className="w-12 h-12 rounded-full border border-[#F57D11]"
                                        path="{{
                                            \App\Models\File::where('id', $user['profiles']['file_id'])->first()->path . '?t=' . time()
                                        }}" />
                                    <h1 class="font-semibold capitalize truncate">{{ $user['fullname'] }}</h1>
                                </div>
                                <p>{{ $user['ago'] }}</p>
                            </a>
                        @elseif($index <= 0)
                            <div class="flex w-full items-center justify-center h-full font-semibold text-gray-500">
                                No user yet.
                            </div>
                        @endif
                    @empty
                        <div class="flex w-full items-center justify-center h-full font-semibold text-gray-500">
                            No user yet.
                        </div>
                    @endforelse
                    <button type="button" data-pd-overlay="#time-in-time-out-modal"
                        data-modal-target="time-in-time-out-modal" data-modal-toggle="time-in-time-out-modal"
                        name="showTimeShift" class="hidden modal-button">Scan Successfully!</button>
                </div>
            </section>
        </div>
    </div>
</x-main-layout>


<script>
    let scannerInstance = null; // Store scanner instance globally

    //const APP_URL = document.querySelector('meta[name="app-url"]').getAttribute("content");

    // swiper
    var swiper = new Swiper(".progress-slide-carousel", {
        loop: true,
        fraction: true,
        autoplay: {
            delay: 1200,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".progress-slide-carousel .swiper-pagination",
            type: "progressbar",
        },
    });

    function closeCamera() {
        if (scannerInstance) {
            alert('hello')
            scannerInstance.clear()
                .then(() => {
                    console.log("Scanner stopped");
                    document.getElementById("reader").innerHTML = ""; // Clear the scanner UI
                })
                .catch(err => {
                    console.error("Error stopping scanner:", err);
                });
        }
    }

    // Initialize QR Scanner
    function initScanner() {
        scannerInstance = new Html5QrcodeScanner('reader', {
            qrbox: {
                width: 400,
                height: 400
            },
            fps: 10
        });

        scannerInstance.render(onScanSuccess, onScanError);
    }

    async function onScanSuccess(decodedText) {
        try {

            let app_url = `{{ url('/scanner/${encodeURIComponent(decodedText)}') }}`;


            const response = await axios.get(app_url);

            // Open modal
            const modalButton = document.querySelector('[name="showTimeShift"]');
            if (modalButton) {
                modalButton.click();
            } else {
                console.error("Modal button not found!");
            }

            // Get elements
            const nameEmail = document.querySelector('[name="email"]');
            const nameFullname = document.querySelector('[name="fullname"]');
            const nameStudentNo = document.querySelector('[name="student_no"]');
            const namePhone = document.querySelector('[name="phone"]');
            const nameQrCode = document.querySelector('[name="qr_code"]');
            const nameTotalHours = document.querySelector('[name="total_hours"]');
            const nameButtonTimeIn = document.querySelector('[name="button_time_in"]');
            const nameButtonTimeOut = document.querySelector('[name="button_time_out"]');
            const nameLoadingButton = document.querySelector('[name="loading_button"]');
            const nameProfilePicture = document.querySelector('[name="profile_picture"]');

            // Ensure all elements exist
            if (!nameStudentNo || !namePhone || !nameQrCode || !nameTotalHours ||
                !nameButtonTimeIn || !nameButtonTimeOut || !nameProfilePicture) {
                console.error("One or more elements were not found in the DOM.");
                return;
            }

            // Assign values
            nameFullname.textContent = response.data.user.firstname + ' ' +
                response.data.user.middlename + ' ' + response.data.user.lastname;
            nameEmail.textContent = response.data.user.email;
            nameStudentNo.textContent = response.data.user.student_no;
            namePhone.textContent = response.data.user.phone;
            nameQrCode.textContent = response.data.user.qr_code;
            nameTotalHours.textContent = "0 Hours";

            //profile pciture
            nameProfilePicture.src = response.data.profile_image;

            // Remove old event listeners
            nameButtonTimeIn.replaceWith(nameButtonTimeIn.cloneNode(true));
            nameButtonTimeOut.replaceWith(nameButtonTimeOut.cloneNode(true));

            // Get the new button references
            const newButtonTimeIn = document.querySelector('[name="button_time_in"]');
            const newButtonTimeOut = document.querySelector('[name="button_time_out"]');


            //new config for the api route
            app_url = `{{ url('/history/') }}`;


            // Add event listeners
            newButtonTimeIn.addEventListener('click', async function() {
                try {
                    newButtonTimeIn.classList.add('hidden');
                    newButtonTimeOut.classList.add('hidden');
                    nameLoadingButton.classList.remove('hidden');
                    nameLoadingButton.classList.add('block');
                    nameLoadingButton.innerHTML =
                        "<div class='flex justify-center items-center w-full'><span class='line-md--loading-loop'></span><span> Time In </span></div>";
                    
                        const res = await axios.post(app_url, {
                        qr_code: response.data.user.qr_code,
                        type: 'time_in',
                    });

                    if (res.data.success) {
                        toastr.success("Time In checked successfully");
                    } else {
                        toastr.error("Failed to check Time In");
                    }

                    setTimeout(() => location.reload(true), 2000);
                } catch (error) {
                    console.error("Error in Time In:", error);
                }
            });

            newButtonTimeOut.addEventListener('click', async function() {
                try {
                    newButtonTimeIn.classList.add('hidden');
                    newButtonTimeOut.classList.add('hidden');
                    nameLoadingButton.classList.remove('hidden');
                    nameLoadingButton.classList.add('block');
                    nameLoadingButton.innerHTML =
                        "<div class='flex justify-center items-center w-full'><span class='line-md--loading-loop'></span><span> Time Out </span></div>";

                    const res = await axios.post(app_url, {
                        qr_code: response.data.user.qr_code,
                        type: 'time_out',
                    });

                    if (res.status === 200) {
                        toastr.success("Time Out checked successfully");
                    } else {
                        toastr.error("Failed to check Time Out");
                    }

                    setTimeout(() => location.reload(true), 2000);
                } catch (error) {
                    console.error("Error in Time Out:", error);
                }
            });

        } catch (error) {
            console.error("Error fetching QR data:", error.response ? error.response.data : error.message);
        }
    }


    const onScanError = (errorMessage) => {
        // Ignore the specific "No MultiFormat Readers" error
        if (!errorMessage.includes("No MultiFormat Readers were able to detect the code")) {
            console.error("QR Scan error:", errorMessage);
        }
    };

    function timeIn() {
        console.log('hello');
    }

    //load all functions if the page is loaded
    // Ensure DOM is fully loaded before initializing scanner
    document.addEventListener('DOMContentLoaded', () => {

        if (window.history.replaceState) {
        window.history.replaceState({}, document.title, window.location.pathname);
        }

        //initialize scanner
        initScanner();

        // Attach event listener to close button after DOM is ready
        document.getElementById("closeButton").addEventListener("click", closeCamera);
    });
</script>

