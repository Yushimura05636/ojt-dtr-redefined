@props(['id' => ''])

{{-- <x-modal.confirmation-email id="confirmation-email-modal" />
openModal="confirmation-email-modal"
className="modal-button" --}}

{{-- email verification --}}
<div id="{{ $id }}" class="pd-overlay hidden">
    <div
        class="w-full h-full fixed top-0 left-0 z-[100] flex items-center justify-center  overflow-x-hidden overflow-y-auto bg-black bg-opacity-70">
        <div
            class="w-auto flex items-center justify-center p-10 transition-all ease-out opacity-0 sm:mx-auto modal-open:opacity-100 modal-open:duration-500">
            <x-form.container routeName="reset-password" method="POST"
                className="flex flex-col p-10 gap-5 bg-white rounded-2xl">
                @csrf

                <x-page-title title="email verification" titleClass="text-xl" />
                <p>Enter your email to reset your password.</p>
                <x-form.input type="email" name_id="email" placeholder="example@gmail.com" small />
                <div class="flex gap-5 items-center justify-end w-full">
                    <x-button tertiary button closeModal="forgot-password-modal" label="Cancel"
                        className="close-modal-button" />
                    <x-button primary label="Submit" submit />
                </div>
            </x-form.container>
        </div>
    </div>
</div>
