<x-main-layout>
    @php
        $schools = [
            [
                'id' => 1,
                'name' => 'STI College Davao',
                'image' => 'resources/img/school-logo/sti.png',
                'is_featured' => true,
            ],
            [
                'id' => 2,
                'name' => 'Ateneo De Davao University',
                'image' => 'resources/img/school-logo/addu.png',
                'is_featured' => true,
            ],
            [
                'id' => 3,
                'name' => 'Holy Cross of Davao College',
                'image' => 'resources/img/school-logo/hcdc.png',
                'is_featured' => true,
            ],
            [
                'id' => 4,
                'name' => 'University of Mindanao',
                'image' => 'resources/img/school-logo/um.png',
                'is_featured' => true,
            ],
        ];
    @endphp

    <main class="w-full h-auto flex flex-col lg:!gap-7 gap-5">
        <div class="w-full flex items-center justify-between">
            <x-button label="Add School" button primary className="px-8" routePath="admin.schools.create" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($schools as $school)
                <a href="{{ route('admin.schools.show', $school['id']) }}"
                    class="bg-white rounded-xl shadow-md lg:!p-7 p-4 flex flex-col items-center justify-between cursor-pointer border border-gray-200 group animate-transition hover:border-[#F57D11]">

                    <div class="flex flex-col gap-5 items-center w-full h-full">
                        <div>
                            <x-image path="{{ $school['image'] }}" className="w-auto h-20" />
                        </div>
                        <h2 class="text-lg font-semibold group-hover:text-[#F57D11] animate-transition text-center">
                            {{ $school['name'] }}
                        </h2>
                    </div>

                    <label class="flex mt-5 items-center space-x-2 cursor-pointer">
                        <span class="text-sm text-gray-500">Featured to login</span>
                        <div class="relative">
                            <input type="checkbox" class="sr-only peer" {{ $school['is_featured'] ? 'checked' : '' }}>
                            <div class="w-10 h-5 bg-gray-300 rounded-full peer-checked:bg-[#F57D11] transition"></div>
                            <div
                                class="absolute left-1 top-1 w-3 h-3 bg-white rounded-full shadow-md transition-all peer-checked:translate-x-5">
                            </div>
                        </div>
                    </label>

                </a>
            @endforeach
        </div>
    </main>
</x-main-layout>

{{-- #F53C11 - red --}}
{{-- #F57D11 - orange --}}
