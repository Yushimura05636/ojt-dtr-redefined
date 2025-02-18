@props(['id' => ''])

{{-- large qr code --}}
<div id="{{ $id }}" class="pd-overlay hidden z-50">
    <div
        class="w-full h-full fixed top-0 left-0 z-[100] flex items-center justify-center  overflow-x-hidden overflow-y-auto bg-black bg-opacity-70">
        <div
            class="w-auto flex items-center justify-center p-10 transition-all ease-out opacity-0 sm:mx-auto modal-open:opacity-100 modal-open:duration-500">
            <div class="flex flex-col px-10 py-5 gap-5 bg-white rounded-2xl">
                <div class="flex items-center justify-between">
                    <h4 class="font-semibold text-gray-900">YOUR PERSONAL QR CODE</h4>
                    <button id="close-button" class="block cursor-pointer close-modal-button" data-pd-overlay="#qr-code-modal"
                        data-modal-target="qr-code-modal">
                        <span class="gg--close-o cursor-pointer hover:text-[#F53C11] text-gray-600"></span>
                    </button>
                </div>
                <div class="w-full h-auto space-y-5 flex flex-col items-center justify-center">
                    <div id="qr-code-container"
                        class="lg:h-auto md:h-98 md:w-98 h-60 w-60 lg:w-auto p-5 overflow-hidden object-center flex items-center justify-center border bg-white rounded-xl border-black">
                        <div id="large-qr-code-img" class="w-full h-full m-auto"></div>
                    </div>
                    <p class="text-sm">
                        <span class="font-bold">QR CODE:</span> <span id="qr-code-text">N/A</span>
                    </p>
                    {{-- 
                        The x-button still wont work when I try from Onclick="event()" qr-code.php to onclick="event()" button.php
                        I will use again the x-button if the script is fixed

                    <x-button tertiary label="Download QR" leftIcon="material-symbols--download-rounded"
                        class="text-sm px-8" id="download-qr-large-btn"/>
                         --}}
                    <button label="download QR" id="download-qr-large-btn"
                        class='px-16 py-3 border rounded-full text-[#F57D11] hover:border-[#F57D11] animate-transition flex items-center justify-center gap-2'>
                        <i class="material-symbols--download-rounded">download</i>
                        Download QR
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 
    this is the script to convert and download qr code
--}}

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // Add event listener to download QR image
        document.getElementById("download-qr-large-btn").addEventListener("click", function() {

            const qrCanvas = document.getElementById("large-qr-code-img").querySelector("canvas");
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

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('close-button').addEventListener("click", function() {
            location.reload();
        })
    })
</script>
