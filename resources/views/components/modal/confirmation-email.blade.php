@props(['id' => ''])

{{-- confirmation --}}
<div id="{{ $id }}" class="pd-overlay hidden">
    <div
        class="w-full h-full fixed top-0 left-0 z-[100] flex items-center justify-center  overflow-x-hidden overflow-y-auto bg-black bg-opacity-70">
        <div
            class="w-auto flex items-center justify-center p-10 transition-all ease-out opacity-0 sm:mx-auto modal-open:opacity-100 modal-open:duration-500">
            <div class="flex flex-col p-10 gap-5 bg-white rounded-2xl">
                <x-page-title title="Email Confirmation" titleClass="text-xl" />
                <p>Check your email! We've sent you a link to reset your password.</p>
                <div class="w-full flex items-center gap-2 justify-end">
                    <x-button tertiary label="Okay" button className="close-modal-button"
                        closeModal="confirmation-email-modal" />
                    <x-button primary label="Go to email" button
                        onClick="window.location.href='https://mail.google.com/mail/u/0/#inbox'" />
                </div>
            </div>
        </div>
    </div>
</div>
