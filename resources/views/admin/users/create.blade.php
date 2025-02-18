{{-- <x-main-layout>
    <x-form.container routeName="admin.users.create.post" className="w-full h-auto">
        <div class="w-full h-full flex flex-col items-center gap-7">

            @if (session('success'))
                <x-modal.flash-msg msg="success" />
            @endif

            <x-page-title title="create intern account" titleClass="lg:!text-2xl md:!text-xl !text-lg"
                vectorClass="lg:!h-4 !h-3" />

            <div class="w-full flex flex-col gap-7">
                <section class="space-y-5 w-full">

                    <x-form.section-title title="Personal Information" vectorClass="lg:h-5 h-3" />
                    <div class="grid sm:grid-cols-3 w-full gap-5">
                        <x-form.input label="First Name" type="text" name_id="firstname" placeholder="John"
                            labelClass="text-lg font-medium" small />
                        <x-form.input label="Last Name" type="text" name_id="lastname" placeholder="Doe"
                            labelClass="text-lg font-medium" small />
                        <x-form.input label="Middle Name" type="text" name_id="middlename" placeholder="Watson"
                            labelClass="text-lg font-medium" small />
                    </div>
                    <div class="grid grid-cols-2 w-full gap-5">
                        <x-form.input label="Gender" name_id="gender" placeholder="Select" small type="select"
                            :options="['male' => 'Male', 'female' => 'Female']" />
                        <x-form.input label="Phone" type="text" name_id="phone" placeholder="+63"
                            labelClass="text-lg font-medium" small />
                    </div>
                    <div class="grid grid-cols-2 w-full gap-5">
                        <x-form.input label="Address" type="text" name_id="address" placeholder="Davao City"
                            labelClass="text-lg font-medium" small />
                        <x-form.input label="School" type="text" name_id="school" placeholder="School name"
                            labelClass="text-lg font-medium" small />
                    </div>

                </section>
                <section class="space-y-5 w-full">
                    
                    <x-form.section-title title="Account Information" vectorClass="lg:h-5 h-3" />
                    <div class="grid grid-cols-2 w-full gap-5">
                        <x-form.input label="Email" name_id="email" placeholder="example@gmail.com"
                            labelClass="text-lg font-medium" small />
                        <x-form.input label="Student No" type="text" name_id="student_no" placeholder="02-0002-60001"
                            labelClass="text-lg font-medium" small />
                    </div>
                    <div class="grid grid-cols-2 w-full gap-5">
                        <x-form.input label="Password" type="password" name_id="password" placeholder="••••••••"
                            labelClass="text-lg font-medium" small />
                        <x-form.input label="Confirm Password" type="password" name_id="password_confirmation"
                            placeholder="••••••••" labelClass="text-lg font-medium" small />
                    </div>
                </section>
                <section class="space-y-5 w-full">
                    <x-form.section-title title="Emergency Contact" vectorClass="lg:h-5 h-3" />
                    <div class="grid sm:grid-cols-3 w-full gap-5">
                        <x-form.input label="Full Name" type="text" name_id="emergency_contact_fullname"
                            placeholder="Johny Doe" labelClass="text-lg font-medium" small />
                        <x-form.input label="Contact No." type="text" name_id="emergency_contact_number"
                            placeholder="+63" labelClass="text-lg font-medium" small />
                        <x-form.input label="Address" type="text" name_id="emergency_contact_address"
                            placeholder="Davao City" labelClass="text-lg font-medium" small />
                    </div>
                </section>

                <div>
                    <x-button primary label="Create Account" submit />
                </div>
            </div>
        </div>
    </x-form.container>
</x-main-layout> --}}

<x-main-layout>

    <div class="h-full w-full">
        <x-form.container routeName="admin.users.create.post" method="POST" className="h-auto w-full flex flex-col gap-5">

            @if (session('success'))
                <x-modal.flash-msg msg="success" />
            @endif

            <div
                class="w-full flex items-center justify-between gap-5 bg-white p-3 border border-gray-200 shadow-lg sticky top-[125px] z-30 rounded-full">
                <x-button routePath="admin.users" label="Back" tertiary button leftIcon="eva--arrow-back-fill"
                    className="px-8" />
                <x-button primary label="Create Account" submit className="px-6" />
            </div>



            <div class="flex flex-col lg:!gap-7 gap-5 pb-10 h-full">
                <section class="flex flex-col gap-5 w-full p-7 border border-gray-200 rounded-lg bg-white">

                    {{-- <div class="">
                        <div class="flex items-center w-full justify-center flex-col gap-4">
                            <div class="w-auto h-auto">
                                <x-image className="w-40 h-40 rounded-full border border-[#F57D11]"
                                    path="resources/img/default-male.png" />
                            </div>
                            <x-button tertiary leftIcon="bx--image" label="Change" button className="px-10" />
                        </div>
                    </div> --}}
                    <div class="flex justify-center">
                        <x-page-title title="create intern account" titleClass="lg:!text-2xl md:!text-xl !text-lg"
                            vectorClass="lg:!h-4 !h-3" />
                    </div>

                    <x-form.section-title title="Personal Information" vectorClass="lg:h-5 h-3" />
                    <div class="grid sm:grid-cols-3 w-full gap-5">
                        <x-form.input label="First Name" type="text" name_id="firstname" placeholder="John"
                            labelClass="text-lg font-medium" small />
                        <x-form.input label="Last Name" type="text" name_id="lastname" placeholder="Doe"
                            labelClass="text-lg font-medium" small />
                        <x-form.input label="Middle Name" type="text" name_id="middlename" placeholder="Watson"
                            labelClass="text-lg font-medium" small />
                    </div>
                    <div class="grid grid-cols-2 w-full gap-5">
                        <x-form.input label="Gender" name_id="gender" placeholder="Select" small type="select"
                            :options="['male' => 'Male', 'female' => 'Female']" />
                        <x-form.input label="Phone" type="text" name_id="phone" placeholder="+63"
                            labelClass="text-lg font-medium" small />
                    </div>
                    <div class="grid grid-cols-2 w-full gap-5">
                        <x-form.input label="Address" type="text" name_id="address" placeholder="Davao City"
                            labelClass="text-lg font-medium" small />
                        <x-form.input label="School" type="text" name_id="school" placeholder="School name"
                            labelClass="text-lg font-medium" small />
                    </div>
                </section>

                <section class="flex flex-col gap-5 w-full p-7 border border-gray-200 rounded-lg bg-white">

                    <x-form.section-title title="Account Information" vectorClass="lg:h-5 h-3" />
                    <div class="grid grid-cols-2 w-full gap-5">
                        <x-form.input label="Email" name_id="email" placeholder="example@gmail.com"
                            labelClass="text-lg font-medium" small />
                        <x-form.input label="Student No" type="text" name_id="student_no" placeholder="02-0002-60001"
                            labelClass="text-lg font-medium" small />
                    </div>
                    <div class="grid grid-cols-2 w-full gap-5">
                        <x-form.input label="Password" type="password" name_id="password" placeholder="••••••••"
                            labelClass="text-lg font-medium" small />
                        <x-form.input label="Confirm Password" type="password" name_id="password_confirmation"
                            placeholder="••••••••" labelClass="text-lg font-medium" small />
                    </div>
                </section>

                <section class="flex flex-col gap-5 w-full p-7 border border-gray-200 rounded-lg bg-white">

                    <x-form.section-title title="Emergency Contact" vectorClass="lg:h-5 h-3" />
                    <div class="grid sm:grid-cols-3 w-full gap-5">
                        <x-form.input label="Full Name" type="text" name_id="emergency_contact_fullname"
                            placeholder="Johny Doe" labelClass="text-lg font-medium" small />
                        <x-form.input label="Contact No." type="text" name_id="emergency_contact_number"
                            placeholder="+63" labelClass="text-lg font-medium" small />
                        <x-form.input label="Address" type="text" name_id="emergency_contact_address"
                            placeholder="Davao City" labelClass="text-lg font-medium" small />
                    </div>
                </section>
            </div>
        </x-form.container>
    </div>
</x-main-layout>
