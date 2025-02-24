{{-- admin login --}}
@if (Request::routeIs('show.admin.login'))
    <x-main-layout>
        @if (session('success'))
            <x-modal.flash-msg msg="success" />
        @elseif ($errors->has('invalid'))
            <x-modal.flash-msg msg="invalid" />
        @elseif (session('invalid'))
            <x-modal.flash-msg msg="invalid" />
        @endif

        <main class="container mx-auto max-w-screen-xl">
            <div class="flex items-center justify-center h-screen p-10 overflow-auto">

                <x-form.container routeName="show.admin.login" method="POST"
                    className="lg:!w-1/2 md:w-2/3 !w-full h-full flex items-center justify-center">
                    <div
                        class="p-10 border border-gray-200 rounded-2xl shadow-xl w-full flex flex-col gap-10 items-center justify-center">
                        <x-logo />
                        <x-page-title title="admin login" titleClass="lg:!text-3xl md:!text-2xl !text-lg"
                            vectorClass="lg:!h-6 md:!h-4 !h-3" />
                        <div class="flex flex-col gap-6 w-full">
                            <x-form.input label="Email" name_id="email" type="email" big
                                placeholder="admin@email.com" />
                            <x-form.input label="Password" name_id="password" type="password" big
                                placeholder="••••••••" />
                            <x-form.input name_id="type" type="password" hidden big placeholder="••••••••"
                                value="admin" />

                            <div class="-mt-4">
                                <x-button primary submit label="Login" className="w-full" big />
                            </div>
                        </div>
                    </div>
                </x-form.container>
            </div>

        </main>
    </x-main-layout>

    {{-- user/intern login --}}
@elseif (Request::routeIs('show.login'))
    <x-main-layout>
        <x-modal.forgot-password id="forgot-password-modal" />
        <x-modal.confirmation-email id="confirmation-email-modal" />

        <x-form.container routeName="login" method="POST"
            className="w-full h-full flex items-center justify-center bg-white container mx-auto max-w-screen-2xl">
            <div class="w-full flex flex-col items-center justify-center gap-7 overflow-x-hidden md:!p-10 p-5">
                @if (session('success'))
                    <x-modal.flash-msg msg="success" />
                @elseif ($errors->has('invalid'))
                    <x-modal.flash-msg msg="invalid" />
                @elseif (session('invalid'))
                    <x-modal.flash-msg msg="invalid" />
                @endif

                <div class="w-full">
                    <x-logo />
                </div>

                <x-page-title title="intern login" titleClass="lg:!text-3xl md:!text-2xl !text-xl"
                    vectorClass="lg:!h-6 md:!h-4 !h-3" />

                <div class="w-full flex flex-col gap-5">
                    <x-form.input label="Email" classLabel="font-medium text-2xl" name_id="email"
                        placeholder="example@gmail.com" labelClass="text-xl font-medium" big />

                    <x-form.input label="Password" classLabel="font-medium text-2xl" name_id="password"
                        placeholder="••••••••" type="password" labelClass="text-xl font-medium" big />
                    <x-form.input name_id="type" type="password" hidden big placeholder="••••••••" value="user" />

                    <section class="flex items-center gap-1 -mt-5">
                        <p>Forgot Password?</p>
                        <button type="button" data-pd-overlay="#forgot-password-modal"
                            data-modal-target="forgot-password-modal" data-modal-toggle="forgot-password-modal"
                            class="modal-button font-bold hover:text-[#F57D11] cursor-pointer">Click
                            here.</button>
                    </section>

                    <div>
                        <x-button primary label="Login" submit big />
                    </div>

                    <article class="wrapper py-10">
                        @php
                            $schools = \App\Models\School::get();
                        @endphp
                        <div class="marquee">
                            <div class="marquee__group">
                                @for ($i = 1; $i <= 3; $i++)
                                    @foreach ($schools as $school)
                                        @if ($school['is_featured'] == 'on')
                                            <x-image className="w-full h-full rounded-lg border"
                                                path="{{ \App\Models\File::where('id', $school['file_id'])->first()['path'] }}" />
                                        @endif
                                    @endforeach
                                @endfor
                            </div>

                            <div aria-hidden="true" class="marquee__group">
                                @for ($i = 1; $i <= 3; $i++)
                                    @foreach ($schools as $school)
                                        @if ($school['is_featured'] == 'on')
                                            <x-image className="w-full h-full rounded-lg border"
                                                path="{{ \App\Models\File::where('id', $school['file_id'])->first()['path'] }}" />
                                        @endif
                                    @endforeach
                                @endfor
                            </div>
                        </div>
                    </article>
                </div>

                <style>
                    :root {
                        --gap: 1rem;
                        --duration: 120s;
                        --scroll-start: 0;
                        --scroll-end: -100%;
                    }

                    .marquee {
                        display: flex;
                        overflow: hidden;
                        user-select: none;
                        gap: var(--gap);
                        mask-image: linear-gradient(to right,
                                rgba(0, 0, 0, 0),
                                rgba(0, 0, 0, 1) 20%,
                                rgba(0, 0, 0, 1) 80%,
                                rgba(0, 0, 0, 0));
                    }

                    .marquee__group {
                        flex-shrink: 0;
                        display: flex;
                        align-items: center;
                        justify-content: space-around;
                        gap: var(--gap);
                        min-width: 100%;
                        animation: scroll-x var(--duration) linear infinite;
                    }

                    @keyframes scroll-x {
                        from {
                            transform: translateX(var(--scroll-start));
                        }

                        to {
                            transform: translateX(var(--scroll-end));
                        }
                    }

                    .marquee img {
                        height: 60px;
                        /* Adjust height as needed */
                        width: auto;
                    }

                    /* Parent wrapper */
                    .wrapper {
                        display: flex;
                        flex-direction: column;
                        gap: var(--gap);
                        margin: auto;
                        max-width: 100vw;
                    }
                </style>
            </div>
        </x-form.container>
    </x-main-layout>
@endif
<script>
    if (window.history.replaceState) {
        window.history.replaceState({}, document.title, window.location.pathname);
    }
</script>

{{-- <x-button tertiary label="Click here." className="modal-button" openModal="forgot-password-modal" button /> --}}
