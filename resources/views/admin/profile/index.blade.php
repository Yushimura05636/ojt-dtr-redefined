<x-main-layout>
    <x-form.container routeName="admin.settings.update" method="POST"
        className="h-auto w-full flex flex-col gap-7 overflow-auto" enctype="multipart/form-data">
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

        <div class="flex items-center justify-end gap-5">
            {{-- <x-button routePath="admin.users.details" :params="['id' => $user->id]" label="Back" tertiary button
                leftIcon="eva--arrow-back-fill" className="px-8" /> --}}
            <x-button primary label="Save Changes" submit leftIcon="eva--save-outline" className="px-8" />
        </div>


        <section class="space-y-5 w-full p-6 border border-gray-200 bg-white rounded-lg">
            <div class="flex items-center w-full justify-center flex-col gap-4">
                <div class="w-auto h-auto">
                    <div
                        class="lg:!w-80 md:!w-60 w-40 lg:!h-80 md:!h-60 h-40 border border-[#F57D11] shadow rounded-full overflow-hidden">
                        <img id="imagePreview"
                            src="{{ \App\Models\File::where('id', Auth::user()->profiles->file_id)->first()->path . '?t=' . time() }}"
                            alt="Profile Image" class="w-full h-full" />
                    </div>
                </div>
                <input type="file" id="uploadButton" name="file" class="hidden" accept="image/*">
                <label for="uploadButton"
                    class="px-16 py-3 border rounded-full text-[#F57D11] hover:border-[#F57D11] animate-transition flex items-center justify-center gap-2 lg:text-sm text-xs cursor-pointer">Upload</label>
            </div>
            <x-form.section-title title="Personal Information" vectorClass="!h-3" />
            <div class="grid md:grid-cols-3 w-full gap-5">
                <x-form.input label="First Name" type="text" name_id="firstname" placeholder="John"
                    value="{{ $user->firstname }}" labelClass="text-lg font-medium" small />
                <x-form.input label="Last Name" type="text" name_id="lastname" placeholder="Doe"
                    value="{{ $user->lastname }}" labelClass="text-lg font-medium" small />
                <x-form.input label="Middle Name" type="text" name_id="middlename" value="{{ $user->middlename }}"
                    placeholder="Watson" labelClass="text-lg font-medium" small />
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
                <x-form.input label="Email" type="email" name_id="email" value="{{ $user->email }}"
                    placeholder="example@gmail.com" labelClass="text-lg font-medium" small />
                {{-- <x-form.input label="School" type="text" name_id="school" placeholder="School name"
                    value="{{ $user->school }}" labelClass="text-lg font-medium" small /> --}}
            </div>
        </section>
        <input type="text" class="hidden" name="user_id" value="{{ $user->id }}" />

        {{-- <section class="space-y-5 w-full p-6 border border-gray-200 bg-white rounded-lg">
            <x-form.section-title title="Account Information" vectorClass="!h-3" />
            <div class="grid grid-cols-2 w-full gap-5">
                <x-form.input label="School ID" type="text" name_id="student_no" placeholder="School ID"
                    value="{{ $user->student_no }}" labelClass="text-lg font-medium" small />
                <x-form.input label="Starting Date" type="date" name_id="starting_date"
                    value="{{ $user->starting_date }}" placeholder="MMM DD, YYY" labelClass="text-lg font-medium"
                    small />
                <x-form.input label="Expiry Date" type="date" name_id="expiry_date" value="{{ $user->expiry_date }}"
                    placeholder="MMM DD, YYY" labelClass="text-lg font-medium" small />
                <x-form.input label="Status" type="select" name_id="status" value="{{ $user->status }}"
                    placeholder="{{ ucfirst($user->status) }}" :options="['active' => 'Active', 'inactive' => 'Inactive']" labelClass="text-lg font-medium"
                    small />
            </div>
        </section> --}}

        {{-- <section class="space-y-5 w-full p-6 border border-gray-200 bg-white rounded-lg">
            <x-form.section-title title="Emergency Contact" vectorClass="!h-3" />
            <div class="grid grid-cols-3 w-full gap-5">
                <x-form.input label="Full Name" type="text" name_id="emergency_contact_fullname"
                    value="{{ $user->emergency_contact_fullname }}" placeholder="Johny Doe"
                    labelClass="text-lg font-medium" small />
                <x-form.input label="Contact No." type="text" name_id="emergency_contact_number"
                    value="{{ $user->emergency_contact_number }}" placeholder="+63" labelClass="text-lg font-medium"
                    small />
                <x-form.input label="Address" type="text" name_id="emergency_contact_address"
                    value="{{ $user->emergency_contact_address }}" placeholder="Davao City"
                    labelClass="text-lg font-medium" small />
                <x-form.input type="text" name_id="user_id" hidden placeholder="user id"
                    value="{{ $user->id }}" labelClass="text-lg font-medium" small />
            </div>
        </section> --}}

    </x-form.container>
</x-main-layout>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const uploadButton = document.querySelector("#uploadButton");
        const imagePreview = document.querySelector("#imagePreview");

        uploadButton.addEventListener("change", function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
