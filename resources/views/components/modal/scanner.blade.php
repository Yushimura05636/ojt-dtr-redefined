@props(['id' => ''])

<!-- HTML5 QR Code Scanner -->
<script src="https://unpkg.com/html5-qrcode"></script>

<!-- Camera -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>

{{-- large qr code --}}
<div id="{{ $id }}" class="pd-overlay hidden">
    <div
        class="w-full h-full fixed top-0 left-0 z-[100] flex items-center justify-center  overflow-x-hidden overflow-y-auto bg-black bg-opacity-70">
        <div
            class="w-1/2 flex items-center justify-center p-10 transition-all ease-out opacity-0 sm:mx-auto modal-open:opacity-100 modal-open:duration-500">
            <div class="flex flex-col px-10 py-5 gap-5 bg-white rounded-2xl w-full">
                <div class="flex flex-col gap-5 items-center justify-center">
                    <h4 class="font-bold text-2xl text-gray-900">QR SCANNER</h4>
                </div>
                <div class="w-full h-auto space-y-5 flex flex-col items-center justify-center">
                    <div
                        class="h-[550px] w-[550px] p-5 overflow-hiddem object-center border bg-white rounded-xl border-black">
                        <!-- Scanner Section -->
                        <div id="reader" class="mt-8 w-full max-w-xl mx-auto"></div>
                    </div>
                    <p class="text-sm text-gray-600">Position the QR code within the frame to scan.</p>
                    <x-button primary label="HIDE SCANNER" leftIcon="mdi--video-off"
                        className="text-sm px-8 close-modal-button" id="closeButton" closeModal="{{ $id }}" />
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize QR Scanner
    function initScanner() {
        const scanner = new Html5QrcodeScanner('reader', {
            qrbox: {
                width: 250,
                height: 250
            },
            fps: 10
        });

        scanner.render(onScanSuccess, onScanError);
    }

    async function onScanSuccess(decodedText) {
        try {

            //modal
            let app_url  = `{{ url('/scanner/${decodedText}') }}`;

            const response = await axios.get(app_url);
            console.log(response); // Access 'valid' from response data
            alert(response.data.user.firstname);

            // ✅ Update HTML content dynamically
            const text = document.getElementById("qrText").value = response.data.user.qr_code;
            const firstName = document.getElementById("firstName").innerHTML = response.data.user.firstname;
            const lastName = document.getElementById("lastName").innerHTML = response.data.user.lastname;
            const email = document.getElementById("email").innerHTML = response.data.user.email;
            const phone = document.getElementById("phone").innerHTML = response.data.user.phone;
            const studentNo = document.getElementById("studentNo").innerHTML = response.data.user.student_no;
            // Clear previous QR code
            document.getElementById('qrcode').innerHTML = '';

            // Create QR code
            const qr = new QRCode(document.getElementById("qrcode"), {
                text: text,
                width: document.getElementById('qrcode').clientWidth,
                height: document.getElementById('qrcode').clientHeight,
                colorDark: '#000000',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.H
            });

        } catch (error) {
            console.error("Error:", error);
        }
    }

    function onScanError(error) {
        console.warn('QR Scan error:', error);
    }

    // Initialize scanner when page loads
    document.addEventListener('DOMContentLoaded', initScanner);
</script>
