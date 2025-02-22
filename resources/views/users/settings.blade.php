<x-main-layout>
    <x-modal.forgot-password id="forgot-password-modal" />
    <x-modal.confirmation-email id="confirmation-email-modal" />
    <div class="w-full">
        <x-form.container routeName="users.settings.update" method="POST" className="h-auto w-full flex flex-col gap-5" enctype="multipart/form-data">
            @method('PUT')

            @if (session('success'))
                <x-modal.flash-msg msg="success" />
            @elseif (session('update'))
                <x-modal.flash-msg msg="update" />
            @elseif ($errors->has('invalid'))
                <x-modal.flash-msg msg="invalid" />
            @elseif (session('invalid'))
                <x-modal.flash-msg msg="invalid" />
            @endif

            <div
                class="w-full flex items-center justify-center gap-5 bg-white p-3 border border-gray-200 shadow-lg sticky top-5 z-30 rounded-full">
                <x-button primary label="Save Changes" submit leftIcon="eva--save-outline" className="px-6" />
                <x-button label="Reset Password" button openModal="forgot-password-modal"
                    className="text-[#F57D11] cursor-pointer hover:underline modal-button lg:text-base text-sm" />
            </div>

            <div class="flex flex-col lg:!gap-7 gap-5 mt-5 h-full">
                <section class="flex flex-col gap-5 w-full p-7 border border-gray-200 rounded-lg bg-white">
                    <div class="flex flex-col items-center gap-5">
                        <div class="h-auto w-auto">
                            <img id="imagePreview" 
                                src="{{$image_url . '?t=' . time()}}" alt="Profile Image"
                                class="lg:!w-80 md:!w-60 w-40 lg:!h-80 md:!h-60 h-40 border border-[#F57D11] shadow rounded-full" />
                        </div>
                        <input type="file" id="uploadButton" name="file" class="hidden" accept="image/*">
                        <label for="uploadButton" class="px-16 py-3 border rounded-full text-[#F57D11] hover:border-[#F57D11] animate-transition flex items-center justify-center gap-2 lg:text-sm text-xs cursor-pointer">Upload</label>
                        
                    </div>
                    
                    <x-form.section-title title="Personal Information" />
                    <div class="grid md:grid-cols-3 w-full gap-5">
                        <x-form.input label="First Name" type="text" name_id="firstname" placeholder="John"
                            value="{{ $user->firstname }}" labelClass="text-lg font-medium" small />
                        <x-form.input label="Last Name" type="text" name_id="lastname" placeholder="Doe"
                            value="{{ $user->lastname }}" labelClass="text-lg font-medium" small />
                        <x-form.input label="Middle Name" type="text" name_id="middlename"
                            value="{{ $user->middlename }}" placeholder="Watson" labelClass="text-lg font-medium"
                            small />
                    </div>
                    <div class="grid grid-cols-2 w-full gap-5">
                        <x-form.input label="Gender" name_id="gender" placeholder="Select a gender" small
                            value="{{ $user->gender }}" type="select" :options="['male' => 'Male', 'female' => 'Female']" />

                        <x-form.input label="Phone" type="text" name_id="phone" placeholder="+63"
                            value="{{ $user->phone }}" labelClass="text-lg font-medium" small />
                    </div>
                    <div class="grid grid-cols-2 w-full gap-5">
                        <x-form.input label="Address" type="text" name_id="address" placeholder="Davao City"
                            value="{{ $user->address }}" labelClass="text-lg font-medium" small />
                            @php
                            $schools = \App\Models\School::get();
                            $user_school = Auth::user(); // Get the logged-in user's school ID
                        
                            $school_options = [];
                            foreach($schools as $school){
                                $school_options[$school->id] = $school->description;
                            }
                        @endphp
                        <x-form.input label="School" name_id="school" placeholder="Select a school" small type="select"
                            :options="$school_options" :value="$user_school->school_id" />
                            {{-- <x-form.input label="School" type="text" name_id="school" placeholder="School name"
                            value="{{ $user->school }}" labelClass="text-lg font-medium" small /> --}}
                    </div>
                </section>

                <section class="flex flex-col gap-5 w-full p-7 border border-gray-200 rounded-lg bg-white">
                    <x-form.section-title title="Account Information" />
                    <div class="grid grid-cols-2 w-full gap-5">
                        <x-form.input label="Email" type="email" name_id="email" value="{{ $user->email }}"
                            placeholder="example@gmail.com" labelClass="text-lg font-medium" small />
                        <x-form.input label="School ID" type="text" name_id="student_no" placeholder="School ID"
                            value="{{ $user->student_no }}" labelClass="text-lg font-medium" small />
                        <x-form.input disabled="true" label="Starting Date" type="date" name_id="starting_date"
                            value="{{ $user->starting_date }}" placeholder="MMM DD, YYY"
                            labelClass="text-lg font-medium" small />
                        <x-form.input disabled="true" label="Expiry Date" type="date" name_id="expiry_date"
                            value="{{ $user->expiry_date }}" placeholder="MMM DD, YYY" labelClass="text-lg font-medium"
                            small />
                    </div>
                </section>

                <section class="flex flex-col gap-5 w-full p-7 border border-gray-200 rounded-lg bg-white h-fit">
                    <x-form.section-title title="Emergency Contact" />
                    <div class="grid md:grid-cols-3 w-full gap-5">
                        <x-form.input label="Full Name" type="text" name_id="emergency_contact_fullname"
                            value="{{ $user->emergency_contact_fullname }}" placeholder="Johny Doe"
                            labelClass="text-lg font-medium" small />
                        <x-form.input label="Contact No." type="text" name_id="emergency_contact_number"
                            value="{{ $user->emergency_contact_number }}" placeholder="+63"
                            labelClass="text-lg font-medium" small />
                        <x-form.input label="Address" type="text" name_id="emergency_contact_address"
                            value="{{ $user->emergency_contact_address }}" placeholder="Davao City"
                            labelClass="text-lg font-medium" small />
                        <x-form.input type="text" name_id="user_id" hidden placeholder="user id"
                            value="{{ $user->id }}" labelClass="text-lg font-medium" small />
                    </div>
                </section>
            </div>
        </x-form.container>
    </div>
</x-main-layout>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const uploadButton = document.querySelector("#uploadButton");
        const imagePreview = document.querySelector("#imagePreview");

        uploadButton.addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
