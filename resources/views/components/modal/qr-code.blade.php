@props(['id' => ''])

{{-- large qr code --}}
<div id="{{ $id }}" class="pd-overlay hidden z-50">
    <div
        class="w-full h-full fixed top-0 left-0 z-[100] flex items-center justify-center  overflow-x-hidden overflow-y-auto bg-black bg-opacity-70">
        <div
            class="w-auto flex items-center justify-center p-10 transition-all ease-out opacity-0 sm:mx-auto modal-open:opacity-100 modal-open:duration-500">
            <div class="flex flex-col px-10 py-5 gap-5 bg-white rounded-2xl">
                    <h4 class="font-semibold text-gray-900 py-2 w-full text-center">YOUR PERSONAL QR CODE</h4>
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
                        <div class="flex gap-2 justify-between w-full">
                            <button label="download QR" id="download-qr-large-btn"
                                class='px-8 py-3 border text-nowrap rounded-full text-[#F57D11] border-[#F57D11] hover:bg-[#F57D11] hover:text-white animate-transition flex items-center justify-center gap-2'>
                                <i class="material-symbols--download-rounded">download</i>
                                Download QR
                            </button>
                            <button id="close-button" class="w-full h-auto close-modal-button px-8 py-3 border border-red-500 text-red-500 rounded-full hover:bg-red-500 hover:text-white animate-transition" data-pd-overlay="#qr-code-modal"
                                data-modal-target="qr-code-modal">
                                Close
                            </button>
                        </div>
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

            // const qrCanvas = document.getElementById("large-qr-code-img").querySelector("canvas");
            // if (qrCanvas) {

            //     // Get the image data URL (base64 format)
            //     const qrImage = qrCanvas.toDataURL("image/png");

            //     // Create an <a> tag dynamically for downloading the image
            //     const downloadLink = document.createElement("a");
            //     downloadLink.href = qrImage;
            //     downloadLink.download = "QR_Code.png"; // Set the default filename for download
            //     document.body.appendChild(downloadLink);
            //     downloadLink.click(); // Trigger the download
            //     document.body.removeChild(
            //         downloadLink); // Clean up the link after triggering the download
            // } else {
            //     console.error("QR code not found in the container!");
            // }
            // Add event listener to download QR image

            const qrCanvas = document.querySelector("#large-qr-code-img canvas");
            if (qrCanvas) {
                // Create a new canvas with white background
                const newCanvas = document.createElement("canvas");
                const ctx = newCanvas.getContext("2d");
                newCanvas.width = qrCanvas.width + 40; // Extra padding
                newCanvas.height = qrCanvas.height + 40;
                
                // Fill white background
                ctx.fillStyle = "white";
                ctx.fillRect(0, 0, newCanvas.width, newCanvas.height);
                
                // Draw QR code in center
                ctx.drawImage(qrCanvas, 20, 20);

                // Convert to image and download
                const qrImage = newCanvas.toDataURL("image/png");
                const downloadLink = document.createElement("a");
                downloadLink.href = qrImage;
                downloadLink.download = "QR_Code.png";
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
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
