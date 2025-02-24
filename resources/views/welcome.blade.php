<x-main-layout>

    {{-- <main class="h-screen overflow-x-hidden w-full bg-white">
        <div id="left-side" class="space-y-10">
            <x-image path="{{ asset('resources/img/logos/rweb_logo.png') }}" className="h-20 w-auto" />
            <div class="space-y-3">
                <h1 class="text-5xl text-[#F57D11] font-bold">Daily Time Record</h1>
                <p class="text-lg text-gray-600">Track Your Internship Hours with Ease!</p>
            </div>
            <div class="flex items-center gap-5">
                <x-button big primary label="Create Account" routePath="show.register" />
                <x-button big tertiary label="Log In" className="font-semibold" routePath="show.login" />
            </div>
        </div>
        <div id="right-side" class="h-auto w-auto relative flex items-end justify-end">
            <svg class="w-[1050px] h-auto rotate-180 absolute right-0 top-0" viewBox="0 0 200 200"
                xmlns="http://www.w3.org/2000/svg">
                <path fill="#F57D12"
                    d="M37,-41.9C52.4,-39.8,72.4,-34.9,77,-24.2C81.6,-13.5,70.9,3,64.3,20.2C57.8,37.5,55.5,55.4,45.5,63.3C35.5,71.1,17.8,69,-0.9,70.2C-19.5,71.4,-39,75.9,-54.2,69.7C-69.4,63.5,-80.2,46.6,-85.3,28.3C-90.3,10.1,-89.5,-9.3,-79.1,-20.8C-68.7,-32.3,-48.6,-35.8,-33.8,-38.1C-19,-40.4,-9.5,-41.6,0.7,-42.5C10.8,-43.4,21.6,-44.1,37,-41.9Z"
                    transform="translate(100 100)" />
            </svg>
            <div class="z-10 relative">
                <x-image className="w-[700px] h-auto filter drop-shadow-xl"
                    path="{{ asset('resources/img/hero-model.png') }}" />

            </div>
        </div>
    </main> --}}

    <main class="h-[calc(100vh)] overflow-auto w-full bg-white flex flex-col items-center justify-center py-5">
        <div id="model" class="w-auto h-auto">
            <x-image className="w-[500px] h-auto filter drop-shadow-xl"
                path="{{ asset('resources/img/hero-model-blob.png') }}" />
        </div>
        <div id="letters" class="flex flex-col gap-3 text-center">
            <h1 class="lg:!text-5xl md:text-3xl text-lg text-[#F57D11] font-bold">Daily Time Record | OJT</h1>
            <p class="lg:!text-lg text-sm text-gray-600">Track Your Internship Hours with Ease!</p>
        </div>
        <div id="buttons" class="flex items-center gap-5 mt-10">
            <x-button big primary label="Create Account" routePath="show.register" />
            <x-button big tertiary label="Log In" className="font-semibold" routePath="show.login" />
        </div>
    </main>

    <script>
        gsap.registerPlugin(ScrollTrigger);
        gsap.fromTo("#model", {
            opacity: 0.5,
            y: -120
        }, {
            opacity: 1,
            y: 0,
            duration: 1.5
        });

        gsap.fromTo("#letters", {
            opacity: 0.2,
        }, {
            opacity: 1,
            duration: 2
        });

        gsap.fromTo("#buttons", {
            opacity: 0.5,
            y: 120
        }, {
            opacity: 1,
            y: 0,
            duration: 1.5
        });
    </script>

</x-main-layout>



{{-- <section id="right-side" class="h-auto w-auto relative flex items-end justify-end">
            <svg class="w-[1050px] h-auto rotate-180 absolute right-0 top-0" viewBox="0 0 200 200"
                xmlns="http://www.w3.org/2000/svg">
                <path fill="#F57D12"
                    d="M37,-41.9C52.4,-39.8,72.4,-34.9,77,-24.2C81.6,-13.5,70.9,3,64.3,20.2C57.8,37.5,55.5,55.4,45.5,63.3C35.5,71.1,17.8,69,-0.9,70.2C-19.5,71.4,-39,75.9,-54.2,69.7C-69.4,63.5,-80.2,46.6,-85.3,28.3C-90.3,10.1,-89.5,-9.3,-79.1,-20.8C-68.7,-32.3,-48.6,-35.8,-33.8,-38.1C-19,-40.4,-9.5,-41.6,0.7,-42.5C10.8,-43.4,21.6,-44.1,37,-41.9Z"
                    transform="translate(100 100)" />
            </svg>
            <div class="z-10 relative">
                <x-image className="w-[700px] h-auto filter drop-shadow-xl"
                    path="{{ asset('resources/img/hero-model.png') }}" />

            </div>
        </section> --}}
