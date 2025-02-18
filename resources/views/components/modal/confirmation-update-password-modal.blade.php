@props(['id' => ''])

{{-- confirmation --}}
<div id="{{ $id }}" class="pd-overlay hidden">
    <div
        class="w-full h-full fixed top-0 left-0 z-[100] flex items-center justify-center  overflow-x-hidden overflow-y-auto bg-black bg-opacity-70">
        <div
            class="w-auto flex items-center justify-center p-10 transition-all ease-out opacity-0 sm:mx-auto modal-open:opacity-100 modal-open:duration-500">
            <div class="flex flex-col p-10 gap-5 bg-white rounded-2xl">
                <x-page-title title="Password Updated" titleClass="text-xl" />
                <p>Your password is now updated. Login Now!</p>
                <div class="w-full flex justify-end">
                    <x-button primary label="Login" button closeModal="{{ $id }}"
                        className="close-modal-button" routePath="show.login" />
                </div>
            </div>
        </div>
    </div>
</div>
