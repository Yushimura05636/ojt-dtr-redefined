<x-main-layout>
    <x-form.container routeName="register" className="w-full h-full">
        <div class="w-full h-full flex flex-col items-center gap-7 pb-10">

            @if (session('success'))
                <x-modal.flash-msg msg="success" />
            @endif

            <div class="w-full">
                <x-logo />
            </div>

            <x-page-title title="create intern account" titleClass="lg:!text-3xl md:!text-2xl !text-lg"
                vectorClass="lg:!h-6 md:!h-4 !h-3" />

            <div class="w-full flex flex-col gap-7 md:pb-10">
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
                    <x-button primary label="Register" submit />
                </div>
            </div>
        </div>
    </x-form.container>
</x-main-layout>
