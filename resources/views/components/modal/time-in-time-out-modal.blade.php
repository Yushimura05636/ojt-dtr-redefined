@props(['id' => ''])

{{-- confirmation --}}
<div id="{{ $id }}" class="pd-overlay hidden">
    <div
        class="w-full h-full fixed top-0 left-0 z-[100] flex items-center justify-center  overflow-x-hidden overflow-y-auto bg-black bg-opacity-70">
        <div
            class="lg:!w-2/3 w-full flex items-center justify-center p-10 transition-all ease-out opacity-0 sm:mx-auto modal-open:opacity-100 modal-open:duration-500">
            <div class="flex flex-col items-center w-full p-10 gap-5 bg-white rounded-2xl">
                <x-page-title title="User Details Found" titleClass="text-xl" />
                <div class="w-fit">
                    <img name="profile_picture" class="w-40 h-40 rounded-full border border-[#F57D11]"
                        src="resources/img/default-male.png" />
                </div>
                <div class="text-center space-y-1">
                    <h1 class="font-semibold text-xl capitalize" name="fullname">fullname_placeholder</h1>
                    <p class="text-[#F57D11]" name="email">email_placeholder</p>
                </div>

                @php
                    $details = [
                        ['label' => 'Student No.', 'value' => '02-134523-223'],
                        ['label' => 'Phone', 'value' => '+63 9123456789'],
                        ['label' => 'QR Code', 'value' => 'dpsfkf_3jnf_34'],
                        ['label' => 'Total Hours', 'value' => '30 hours'],
                    ];
                @endphp

                <div class="grid grid-cols-2 gap-4 w-full">
                    {{-- @foreach ($details as $detail)
                    <section class="p-4 border border-gray-200 bg-white rounded-lg w-full">
                        <h1 class="text-sm text-[#F53C11] font-semibold">{{ $detail['label'] }}</h1>
                        <span class="w-full flex justify-end">
                            <h1 class="text-lg text-black">{{ $detail['value'] }}</h1>
                        </span>
                    </section>
                    @endforeach --}}
                    <section class="p-4 border border-gray-200 bg-white rounded-lg w-full">
                        <h1 class="text-sm text-[#F53C11] font-semibold">Student No.</h1>
                        <span class="w-full flex justify-end">
                            <h1 class="text-lg text-black truncate" name="student_no">student_no_placeholder</h1>
                        </span>
                    </section>
                    <section class="p-4 border border-gray-200 bg-white rounded-lg w-full">
                        <h1 class="text-sm text-[#F53C11] font-semibold">Phone</h1>
                        <span class="w-full flex justify-end">
                            <h1 class="text-lg text-black truncate" name="phone">phone_placeholder</h1>
                        </span>
                    </section>
                    <section class="p-4 border border-gray-200 bg-white rounded-lg w-full">
                        <h1 class="text-sm text-[#F53C11] font-semibold">QR Code</h1>
                        <span class="w-full flex justify-end">
                            <h1 class="text-lg text-black truncate" name="qr_code">qr_code_placeholder</h1>
                        </span>
                    </section>
                    <section class="p-4 border border-gray-200 bg-white rounded-lg w-full">
                        <h1 class="text-sm text-[#F53C11] font-semibold">Total Hours</h1>
                        <span class="w-full flex justify-end">
                            <h1 class="text-lg text-black truncate" name="total_hours">total_hours_placeholder</h1>
                        </span>
                    </section>
                </div>
                <div class="w-full flex items-center gap-4 justify-center">
                    {{-- <button type="button" name="button_time_in" class="close-modal-button">Time In</button> --}}
                    <x-button button name="button_time_in" label="Time In" primary className="px-2 text-sm w-full"
                        big />
                    <x-button button name="button_time_out" label="Time Out" primary className="px-2 text-sm w-full"
                        big />
                    {{-- <x-button leftIcon="line-md--loading-loop" label="Loading" name="loading_button" secondary
                        className="w-full text-sm px-2 text-[#F57D11] hidden" /> --}}
                    <div name="loading_button" class="w-full text-sm px-2 text-[#F57D11] hidden"></div>
                </div>
                <div class="w-full flex justify-center">
                    <x-button label="Re-scan QR Code" button
                        className="close-modal-button hover:underline hover:text-[#F57D11] w-fit"
                        closeModal="{{ $id }}" onClick="location.reload(true)" />
                </div>
            </div>
        </div>
    </div>
</div>
