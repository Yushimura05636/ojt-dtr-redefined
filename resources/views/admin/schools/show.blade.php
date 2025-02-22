<x-main-layout>
    <div class="mb-5">
        <x-button routePath="admin.schools" label="Back" tertiary button showLabel="{{ true }}"
            leftIcon="eva--arrow-back-fill" className="lg:!px-8 px-3 bg-white" />
    </div>

    <div class="max-w-lg mx-auto bg-white lg:!p-7 p-5 rounded-lg shadow-md space-y-7">
        <x-form.section-title title="School" />
        <form action="{{ route('admin.schools.show.update', $school['id']) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700" for="name">School Name</label>
                <input type="text" name="name" id="name" required
                    class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-[#F57D11] focus:border-[#F57D11]"
                    value="{{ old('name', $school['name']) }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">School Logo</label>

                @if ($school['image'])
                    <div id="previewContainer" class="w-full my-2">
                        <img id="imagePreview" class="w-auto h-20" src="{{ asset($school['image']) }}">
                    </div>
                @else
                    <div id="previewContainer" class="hidden w-full my-2">
                        <img id="imagePreview" class="w-auto h-20">
                    </div>
                @endif

                <input type="file" name="file" accept="image/*"
                    class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-[#F57D11] focus:border-[#F57D11] cursor-pointer"
                    onchange="previewImage(event)">
            </div>

            <label class="flex items-center space-x-2 cursor-pointer">
                <span class="text-sm text-gray-500">Featured to login</span>
                <div class="relative">
                    <input type="checkbox" class="sr-only peer" name="is_featured"
                        {{ $school['is_featured'] ? 'checked' : '' }}>
                    <div class="w-10 h-5 bg-gray-300 rounded-full peer-checked:bg-[#F57D11] transition"></div>
                    <div
                        class="absolute left-1 top-1 w-3 h-3 bg-white rounded-full shadow-md transition-all peer-checked:translate-x-5">
                    </div>
                </div>
            </label>

            <x-button label="Save Changes" submit primary className="w-full lg:!text-base" />
        </form>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById("imagePreview");
            const previewContainer = document.getElementById("previewContainer");

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove("hidden");
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-main-layout>