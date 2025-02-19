<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<x-main-layout>
    <x-modal.qr-code id="qr-code-modal" />

    <main class="w-full flex flex-col gap-5 pb-5">
        <div class="flex md:flex-row flex-col gap-7 md:!h-[350px] !h-full w-full">
            <section class="w-full h-full">
                <div
                    class="flex items-center justify-center gap-2 bg-gradient-to-r from-[#F57D11] via-[#F57D11]/90 to-[#F53C11] px-3 py-2 rounded-t-lg text-white h-fit">
                    <span class="fluent--scan-qr-code-24-filled"></span>
                    <h1 class="font-semibold">Total Scans</h1>
                    <p class="px-2 py-1 rounded-md border font-semibold bg-white text-[#F53C11]">
                        {{ $totalScan }}
                    </p>
                </div>
                <div
                    class="p-5 rounded-b-lg border border-gray-200 bg-white w-full h-full text-center gap-3 flex flex-col items-center justify-center">
                    <h1 class="text-sm font-semibold">YOUR PERSONAL QR CODE</h1>
                    <!-- Button with QR Code -->
                    <span hidden id="hidden-data-qr-text">{{ $user->qr_code }}</span>
                    <button data-modal-target="qr-code-modal" data-qr-text="{{ $user->qr_code }}"
                        class="modal-button h-40 w-40 p-5 overflow-hidden flex items-center justify-center border bg-white rounded-xl border-black cursor-pointer">
                        <!-- Small QR Code -->
                        <div id="small-qr-code-img"></div>
                    </button>
                    <p class="text-xs font-medium">Click QR to enlarge</p>
                    <button
                        class='py-3 border rounded-full text-[#F57D11] hover:border-[#F57D11] animate-transition flex items-center justify-center gap-2
                                            text-sm px-8'
                        id="download-qr-small-btn">
                        <span class="material-symbols--download-rounded">download</span>
                        Download QR
                    </button>
                </div>
            </section>

            <section class="h-full w-full border border-gray-200 rounded-lg">
                <div
                    class="flex items-center justify-center gap-1 px-7 py-3 bg-gradient-to-r from-[#F57D11] via-[#F57D11]/90 to-[#F53C11] rounded-t-lg text-white shadow-md w-full border border-[#F57D11]">
                    <span class="material-symbols--history-rounded w-6 h-6"></span>
                    <h1 class="font-semibold">Logged History</h1>
                </div>
                <div class="md:!h-full !h-60 w-full bg-white overflow-auto rounded-b-lg border">
                    <div class=" text-black flex flex-col items-start justify-start">
                        @foreach ($histories as $history)
                            <section
                                class="px-7 py-5 w-full flex justify-between items-center border-b border-gray-200">
                                <div class="">
                                    <section class="font-bold text-lg">{{ $history['timeFormat'] }}
                                    </section>
                                    <p class="text-sm font-medium text-gray-700">
                                        {{ $history['datetime'] }}</p>
                                </div>
                                @if ($history['description'] === 'time in')
                                    <div
                                        class="text-green-500 flex items-center gap-1 select-none text-sm font-semibold">
                                        <p>Time in</p>
                                    </div>
                                @else
                                    <div class="text-red-500 flex items-center gap-1 select-none text-sm font-semibold">
                                        <p>Time out</p>
                                    </div>
                                @endif
                            </section>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>

        <div class="flex md:flex-row flex-col gap-7 h-auto w-full md:!mt-14 mt-0">

            <section class="p-7 rounded-lg border border-gray-200 bg-white w-full flex flex-col gap-3">
                <x-page-title title="Additional Information" />
                <hr>
                <div class="space-y-2">
                    <section class="flex md:flex-row flex-col items-start flex-wrap text-wrap sm:gap-5 gap-x-2">
                        <h1 class="text-base font-semibold">Phone No.</h1>
                        <p class=" text-base">+63 {{ $user->phone }}</p>
                    </section>
                    <section class="flex md:flex-row flex-col items-start flex-wrap text-wrap sm:gap-5 gap-x-2">
                        <h1 class="text-base font-semibold">Address</h1>
                        <p class=" text-base ">{{ $user->address }}</p>
                    </section>
                    <section class="flex md:flex-row flex-col items-start flex-wrap text-wrap sm:gap-5 gap-x-2">
                        <h1 class="text-base font-semibold">School</h1>
                        <p class=" text-base ">{{ $user->school }}</p>
                    </section>
                    <section class="flex md:flex-row flex-col items-start flex-wrap text-wrap sm:gap-5 gap-x-2">
                        <h1 class="text-base font-semibold">Account Started</h1>
                        <p class=" text-base ">{{ $userTimeStarted }}</p>
                    </section>
                </div>
            </section>

            <section class="p-7 rounded-lg border border-gray-200 bg-white w-full flex flex-col gap-3">
                <x-page-title title="Emergency Contact" />
                <hr>
                <div class="space-y-2">
                    <section class="flex md:flex-row flex-col items-start sm:gap-5 gap-x-2 text-wrap">
                        <h1 class="text-base font-semibold">Name</h1>
                        <p class=" text-base ">{{ $user->emergency_contact_fullname }}</p>
                    </section>
                    <section class="flex md:flex-row flex-col items-start sm:gap-5 gap-x-2 text-wrap">
                        <h1 class="text-base font-semibold">Contact No.</h1>
                        <p class=" text-base ">+63 {{ $user->emergency_contact_number }}</p>
                    </section>
                    <section class="flex md:flex-row flex-col items-start sm:gap-5 gap-x-2 text-wrap">
                        <h1 class="text-base font-semibold">Address</h1>
                        <p class=" text-base ">{{ $user->emergency_contact_address }}</p>
                    </section>
                </div>
            </section>
        </div>

        <div class="p-7 rounded-lg border border-gray-200 bg-white w-full">
            <div class="flex w-full justify-between gap-2 items-end mb-3">
                <x-page-title title="Request Status" />
                <a href="{{ route('users.request') }}"
                    class="lg:!text-sm text-xs text-[#F53C11] hover:underline underline-offset-4 cursor-pointer font-semibold">
                    View All
                </a>
            </div>
            <hr>

            {{-- dummy data | sort from latest --}}
            <div class="overflow-auto h-[250px] w-full">
                @foreach ($downloadRequest as $request)
                    <a href="{{ route('users.request') }}"
                        class="px-5 py-3 hover:bg-gray-100 border-b border-gray-300 w-full flex items-center justify-between gap-5">

                        <h1 class="truncate">Request for DTR Approval</h1>
                        @if ($request['status'] === 'approved')
                            <div class="w-1/2">
                                <p class="lg:!text-sm text-xs font-semibold text-green-500 truncate">Has been approved.
                                </p>
                                {{-- <p class="lg:!text-sm text-xs font-semibold text-green-500 truncate">Ready to download</p>
                                <p class="lg:!text-sm text-xs font-semibold text-red-500 truncate">Declined approval</p> --}}
                            </div>
                        @endif
                        @if ($request['status'] === 'declined')
                            <div class="w-1/2">
                                <p class="lg:!text-sm text-xs font-semibold text-red-500 truncate">Has been declined.
                                </p>
                                {{-- <p class="lg:!text-sm text-xs font-semibold text-green-500 truncate">Ready to download</p>
                                <p class="lg:!text-sm text-xs font-semibold text-red-500 truncate">Declined approval</p> --}}
                            </div>
                        @endif
                        @if ($request['status'] === 'pending')
                            <div class="w-1/2">
                                <p class="lg:!text-sm text-xs font-semibold text-blue-500 truncate">Waiting for approval...
                                </p>
                                {{-- <p class="lg:!text-sm text-xs font-semibold text-green-500 truncate">Ready to download</p>
                                <p class="lg:!text-sm text-xs font-semibold text-red-500 truncate">Declined approval</p> --}}
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-semibold text-gray-600">{{Carbon\Carbon::parse($request['created_at'])->format('M d, Y')}}</p>
                        </div>
                    </a>
                @endforeach

                {{-- <p class="flex items-center justify-center h-full w-full font-semibold text-gray-500">You don't have
                    request yet.</p> --}}
            </div>
        </div>
    </main>
</x-main-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Generate the small QR code when the page loads
        const qrCodeText = document.getElementById("hidden-data-qr-text").innerText;

        new QRCode(document.getElementById("small-qr-code-img"), {
            text: qrCodeText,
            width: 120,
            height: 120
        });

        // Add event listener to download QR image
        document.getElementById("download-qr-small-btn").addEventListener("click", function() {

            const qrCanvas = document.getElementById("small-qr-code-img").querySelector("canvas");
            if (qrCanvas) {
                // Get the image data URL (base64 format)
                const qrImage = qrCanvas.toDataURL("image/png");

                // Create an <a> tag dynamically for downloading the image
                const downloadLink = document.createElement("a");
                downloadLink.href = qrImage;
                downloadLink.download = "QR_Code.png"; // Set the default filename for download
                document.body.appendChild(downloadLink);
                downloadLink.click(); // Trigger the download
                document.body.removeChild(
                    downloadLink); // Clean up the link after triggering the download
            } else {
                console.error("QR code not found in the container!");
            }
        });
    });

    //this one for clicking the modal and passing some data in the enlarge modal
    document.addEventListener("DOMContentLoaded", function() {
        const qrButtons = document.querySelectorAll("[data-modal-target='qr-code-modal']");

        qrButtons.forEach(button => {
            button.addEventListener("click", function() {
                const qrText = this.getAttribute("data-qr-text");

                console.log("QR Modal Opened!", qrText);

                document.getElementById("qr-code-text").innerText = qrText;

                // Generate new QR code
                new QRCode(document.getElementById("large-qr-code-img"), {
                    text: qrText,
                    width: 350,
                    height: 350
                });

                // Show the modal
                document.getElementById("qr-code-modal").classList.remove("hidden");
            });
        });

        // Close modal
        document.querySelectorAll(".close-modal-button").forEach(button => {
            button.addEventListener("click", function() {
                document.getElementById("qr-code-modal").classList.add("hidden");
            });
        });
    });
</script>
