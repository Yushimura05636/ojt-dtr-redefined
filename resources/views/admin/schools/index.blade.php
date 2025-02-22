<x-main-layout>
    {{-- @php
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
    @endphp --}}

    <main class="w-full h-auto flex flex-col lg:!gap-7 gap-5">
        <div class="w-full flex items-center justify-between">
            <x-button label="Add School" button primary className="px-8" routePath="admin.schools.create" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($schools as $school)
                <a href="{{ route('admin.schools.show', $school['id']) }}"
                    class="relative bg-white rounded-xl shadow-md lg:!p-7 p-4 flex flex-col items-center justify-between cursor-pointer border border-gray-200 group animate-transition hover:border-[#F57D11]">

                    <div class="flex flex-col gap-5 items-center w-full h-full">
                        <div>
                            <x-image path="{{ $school['image'] }}" className="w-auto h-20" />
                        </div>
                        <h2 class="text-lg font-semibold group-hover:text-[#F57D11] animate-transition text-center">
                            {{ $school['name'] }}
                        </h2>
                    </div>

                    @if ($school['is_featured'] == 'on')
                        <div class="absolute top-3 left-0">
                            <span class="text-white bg-[#F57D11] rounded-r-lg px-5 py-1 text-sm">Featured</span>
                        </div>
                    @endif
                </a>
            @endforeach
        </div>
    </main>
</x-main-layout>

{{-- #F53C11 - red --}}
{{-- #F57D11 - orange --}}