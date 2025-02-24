<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>

    <link rel="icon" href="{{ asset('resources/img/rweb_icon.png') }}" type="image/x-icon">

    {{-- <link rel="stylesheet" href=" {{ asset('build/assets/app.css') }}">
    <script src="{{ asset('build/assets/app.js') }}"></script> --}}
{{-- 
    <link rel="stylesheet" href=" {{ 'resources/css/app.css' }}">
    <script src="{{ 'resources/js/app.js' }}"></script> --}}

    <script src="https://cdn.tailwindcss.com"></script>

    {{-- modal script --}}
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/js/pagedone.js"></script>

    {{-- font url --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- hedvig font --}}
    <link href="https://fonts.googleapis.com/css2?family=Hedvig+Letters+Sans&display=swap" rel="stylesheet">

    {{-- swiper --}}
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Pusher Beams & Laravel Echo -->
    <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>

    <!-- Include Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

    <!-- Include jQuery (required for Toastr) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Include Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        Pusher.logToConsole = true; // Debugging, remove in production

        console.log('hello yo!');

        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
            forceTLS: true
        });

        var user_id = "{{ auth()->id() }}"; // Get logged-in user's ID

        var channel = pusher.subscribe("public-notifications");

        // ✅ Listen only to events specific to this user
        channel.bind(`user-notification-${user_id}`, function(data) {
            let audio = new Audio('/resources/sfx/notification_sound_sfx.ogg');
            audio.play();

            if (/declined/i.test(data.message)) {
                toastr.error(data.message);
            } else if (/approved/i.test(data.message)) {
                toastr.success(data.message);
            } else {

                toastr.success(data.message);
            }
        });

        alert(user_id)
    </script>


    <style>
        .swiper-wrapper {
            width: 100%;
            height: 100%;
            -webkit-transition-timing-function: linear !important;
            transition-timing-function: linear !important;
            position: relative;
        }

        .swiper-pagination-progressbar .swiper-pagination-progressbar-fill {
            background: #F57D11 !important;
        }

        .animate-transition {
            transition: all 0.15s ease-in;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 0.5rem;
            /* Equivalent to w-2 */
            height: 0.5rem;
            /* Equivalent to h-2 */
        }

        /* Scrollbar track */
        ::-webkit-scrollbar-track {
            background-color: #D1D5DB;
            /* Equivalent to bg-gray-300 */
        }

        /* Scrollbar thumb */
        ::-webkit-scrollbar-thumb {
            background-color: #6B7280;
            /* Equivalent to bg-gray-500 */
        }

        /* Scrollbar thumb hover state */
        ::-webkit-scrollbar-thumb:hover {
            background-color: #000000;
            /* Equivalent to bg-black */
        }
    </style>

    <style>
        .material-symbols--school-outline-rounded {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='M6.05 17.775q-.5-.275-.775-.737T5 16v-4.8L2.6 9.875q-.275-.15-.4-.375T2.075 9t.125-.5t.4-.375l8.45-4.6q.225-.125.463-.188T12 3.275t.488.063t.462.187l9.525 5.2q.25.125.388.363T23 9.6V16q0 .425-.288.713T22 17t-.712-.288T21 16v-5.9l-2 1.1V16q0 .575-.275 1.038t-.775.737l-5 2.7q-.225.125-.462.188t-.488.062t-.488-.062t-.462-.188zM12 12.7L18.85 9L12 5.3L5.15 9zm0 6.025l5-2.7V12.25l-4.025 2.225q-.225.125-.475.188t-.5.062t-.5-.062t-.475-.188L7 12.25v3.775zm0-3'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .ph--hand-deposit {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 256 256'%3E%3Cpath fill='%23000' d='M128 35.31V128a8 8 0 0 1-16 0V35.31L93.66 53.66a8 8 0 0 1-11.32-11.32l32-32a8 8 0 0 1 11.32 0l32 32a8 8 0 0 1-11.32 11.32Zm64 88.31V96a16 16 0 0 0-16-16h-16a8 8 0 0 0 0 16h16v80.4a28 28 0 0 0-44.25 33.6l.24.38l22.26 34a8 8 0 0 0 13.39-8.76l-22.13-33.79A12 12 0 0 1 166.4 190c.07.13.15.26.23.38l10.68 16.31a8 8 0 0 0 14.69-4.38V144a74.84 74.84 0 0 1 24 54.69V240a8 8 0 0 0 16 0v-41.35a90.89 90.89 0 0 0-40-75.03M80 80H64a16 16 0 0 0-16 16v104a8 8 0 0 0 16 0V96h16a8 8 0 0 0 0-16'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .iconamoon--close-light {
            display: inline-block;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='none' stroke='%23000' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m7 7l10 10M7 17L17 7'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .uil--check {
            display: inline-block;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='M18.71 7.21a1 1 0 0 0-1.42 0l-7.45 7.46l-3.13-3.14A1 1 0 1 0 5.29 13l3.84 3.84a1 1 0 0 0 1.42 0l8.16-8.16a1 1 0 0 0 0-1.47'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .basil--eye-solid {
            display: inline-block;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='M12 9.75a2.25 2.25 0 1 0 0 4.5a2.25 2.25 0 0 0 0-4.5'/%3E%3Cpath fill='%23000' fill-rule='evenodd' d='M12 5.5c-2.618 0-4.972 1.051-6.668 2.353c-.85.652-1.547 1.376-2.036 2.08c-.48.692-.796 1.418-.796 2.067s.317 1.375.796 2.066c.49.705 1.186 1.429 2.036 2.08C7.028 17.45 9.382 18.5 12 18.5s4.972-1.051 6.668-2.353c.85-.652 1.547-1.376 2.035-2.08c.48-.692.797-1.418.797-2.067s-.317-1.375-.797-2.066c-.488-.705-1.185-1.429-2.035-2.08C16.972 6.55 14.618 5.5 12 5.5M8.25 12a3.75 3.75 0 1 1 7.5 0a3.75 3.75 0 0 1-7.5 0' clip-rule='evenodd'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .material-symbols--archive-rounded {
            display: inline-block;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='M5 21q-.825 0-1.412-.587T3 19V6.525q0-.35.113-.675t.337-.6L4.7 3.725q.275-.35.687-.538T6.25 3h11.5q.45 0 .863.188t.687.537l1.25 1.525q.225.275.338.6t.112.675V19q0 .825-.587 1.413T19 21zm.4-15h13.2l-.85-1H6.25zm6.6 4q-.425 0-.712.288T11 11v3.2l-.9-.9q-.275-.275-.7-.275t-.7.275t-.275.7t.275.7l2.6 2.6q.3.3.7.3t.7-.3l2.6-2.6q.275-.275.275-.7t-.275-.7t-.7-.275t-.7.275l-.9.9V11q0-.425-.288-.712T12 10'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .mi--notification {
            display: inline-block;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='M10.146 3.248a2 2 0 0 1 3.708 0A7 7 0 0 1 19 10v4.697l1.832 2.748A1 1 0 0 1 20 19h-4.535a3.501 3.501 0 0 1-6.93 0H4a1 1 0 0 1-.832-1.555L5 14.697V10c0-3.224 2.18-5.94 5.146-6.752M10.586 19a1.5 1.5 0 0 0 2.829 0zM12 5a5 5 0 0 0-5 5v5a1 1 0 0 1-.168.555L5.869 17H18.13l-.963-1.445A1 1 0 0 1 17 15v-5a5 5 0 0 0-5-5'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .iconamoon--arrow-down-2 {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='none' stroke='%23000' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m7 10l5 5m0 0l5-5'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .lucide--check-check {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='none' stroke='%23000' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M18 6L7 17l-5-5m20-2l-7.5 7.5L13 16'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }


        .icon-park-outline--to-top-one {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 48 48'%3E%3Cpath fill='none' stroke='%23000' stroke-linecap='round' stroke-linejoin='round' stroke-width='4' d='m12 33l12-12l12 12M12 13h24'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .mingcute--paper-line {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cg fill='none'%3E%3Cpath d='m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z'/%3E%3Cpath fill='%23000' d='M16 3a3 3 0 0 1 2.995 2.824L19 6v10h.75c.647 0 1.18.492 1.244 1.122l.006.128V19a3 3 0 0 1-2.824 2.995L18 22H8a3 3 0 0 1-2.995-2.824L5 19V9H3.25a1.25 1.25 0 0 1-1.244-1.122L2 7.75V6a3 3 0 0 1 2.824-2.995L5 3zm0 2H7v14a1 1 0 1 0 2 0v-1.75c0-.69.56-1.25 1.25-1.25H17V6a1 1 0 0 0-1-1m3 13h-8v1c0 .35-.06.687-.17 1H18a1 1 0 0 0 1-1zm-7-6a1 1 0 1 1 0 2h-2a1 1 0 1 1 0-2zm2-4a1 1 0 1 1 0 2h-4a1 1 0 0 1 0-2zM5 5a1 1 0 0 0-.993.883L4 6v1h1z'/%3E%3C/g%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .eva--arrow-back-fill {
            display: inline-block;
            width: 18px;
            height: 18px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='M19 11H7.14l3.63-4.36a1 1 0 1 0-1.54-1.28l-5 6a1 1 0 0 0-.09.15c0 .05 0 .08-.07.13A1 1 0 0 0 4 12a1 1 0 0 0 .07.36c0 .05 0 .08.07.13a1 1 0 0 0 .09.15l5 6A1 1 0 0 0 10 19a1 1 0 0 0 .64-.23a1 1 0 0 0 .13-1.41L7.14 13H19a1 1 0 0 0 0-2'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .line-md--loading-loop {
            display: inline-block;
            width: 20px;
            height: 20px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='none' stroke='%23000' stroke-dasharray='16' stroke-dashoffset='16' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 3c4.97 0 9 4.03 9 9'%3E%3Canimate fill='freeze' attributeName='stroke-dashoffset' dur='0.4s' values='16;0'/%3E%3CanimateTransform attributeName='transform' dur='3s' repeatCount='indefinite' type='rotate' values='0 12 12;360 12 12'/%3E%3C/path%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .cuida--user-add-outline {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cg class='user-add-outline'%3E%3Cg fill='%23000' fill-rule='evenodd' class='Vector' clip-rule='evenodd'%3E%3Cpath d='M9.5 10a2 2 0 1 0 0-4a2 2 0 0 0 0 4m0 2a4 4 0 1 0 0-8a4 4 0 0 0 0 8m8.975-4a1 1 0 0 1 1 1v1.475h1.475a1 1 0 1 1 0 2h-1.475v1.475a1 1 0 1 1-2 0v-1.475H16a1 1 0 1 1 0-2h1.475V9a1 1 0 0 1 1-1M3.354 15.176C4.311 13.836 5.77 13 7.643 13h3.714c1.873 0 3.332.837 4.289 2.176C16.577 16.479 17 18.202 17 20a1 1 0 1 1-2 0c0-1.516-.36-2.793-.981-3.661c-.595-.832-1.457-1.339-2.662-1.339H7.643c-1.205 0-2.067.507-2.662 1.339c-.62.868-.981 2.145-.981 3.66a1 1 0 1 1-2 0c0-1.797.422-3.52 1.354-4.823'/%3E%3Cpath d='M2 20a1 1 0 0 1 1-1h12.969a1 1 0 0 1 0 2H3a1 1 0 0 1-1-1'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .material-symbols--co-present-outline {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='M21 21V5H3v8H1V5q0-.825.588-1.412T3 3h18q.825 0 1.413.588T23 5v14q0 .825-.587 1.413T21 21M9 14q-1.65 0-2.825-1.175T5 10t1.175-2.825T9 6t2.825 1.175T13 10t-1.175 2.825T9 14m0-2q.825 0 1.413-.587T11 10t-.587-1.412T9 8t-1.412.588T7 10t.588 1.413T9 12M1 22v-2.8q0-.85.438-1.562T2.6 16.55q1.55-.775 3.15-1.162T9 15t3.25.388t3.15 1.162q.725.375 1.163 1.088T17 19.2V22zm2-2h12v-.8q0-.275-.137-.5t-.363-.35q-1.35-.675-2.725-1.012T9 17t-2.775.338T3.5 18.35q-.225.125-.363.35T3 19.2zm6 0'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .solar--settings-linear {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cg fill='none' stroke='%23000' stroke-width='1.5'%3E%3Ccircle cx='12' cy='12' r='3'/%3E%3Cpath d='M13.765 2.152C13.398 2 12.932 2 12 2s-1.398 0-1.765.152a2 2 0 0 0-1.083 1.083c-.092.223-.129.484-.143.863a1.62 1.62 0 0 1-.79 1.353a1.62 1.62 0 0 1-1.567.008c-.336-.178-.579-.276-.82-.308a2 2 0 0 0-1.478.396C4.04 5.79 3.806 6.193 3.34 7s-.7 1.21-.751 1.605a2 2 0 0 0 .396 1.479c.148.192.355.353.676.555c.473.297.777.803.777 1.361s-.304 1.064-.777 1.36c-.321.203-.529.364-.676.556a2 2 0 0 0-.396 1.479c.052.394.285.798.75 1.605c.467.807.7 1.21 1.015 1.453a2 2 0 0 0 1.479.396c.24-.032.483-.13.819-.308a1.62 1.62 0 0 1 1.567.008c.483.28.77.795.79 1.353c.014.38.05.64.143.863a2 2 0 0 0 1.083 1.083C10.602 22 11.068 22 12 22s1.398 0 1.765-.152a2 2 0 0 0 1.083-1.083c.092-.223.129-.483.143-.863c.02-.558.307-1.074.79-1.353a1.62 1.62 0 0 1 1.567-.008c.336.178.579.276.819.308a2 2 0 0 0 1.479-.396c.315-.242.548-.646 1.014-1.453s.7-1.21.751-1.605a2 2 0 0 0-.396-1.479c-.148-.192-.355-.353-.676-.555A1.62 1.62 0 0 1 19.562 12c0-.558.304-1.064.777-1.36c.321-.203.529-.364.676-.556a2 2 0 0 0 .396-1.479c-.052-.394-.285-.798-.75-1.605c-.467-.807-.7-1.21-1.015-1.453a2 2 0 0 0-1.479-.396c-.24.032-.483.13-.82.308a1.62 1.62 0 0 1-1.566-.008a1.62 1.62 0 0 1-.79-1.353c-.014-.38-.05-.64-.143-.863a2 2 0 0 0-1.083-1.083Z'/%3E%3C/g%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .akar-icons--dashboard {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='none' stroke='%23000' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5a2 2 0 0 1 2-2h6v18H4a2 2 0 0 1-2-2zm12-2h6a2 2 0 0 1 2 2v5h-8zm0 11h8v5a2 2 0 0 1-2 2h-6z'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .material-symbols--download-rounded {
            display: inline-block;
            width: 18px;
            height: 18px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='M12 15.575q-.2 0-.375-.062T11.3 15.3l-3.6-3.6q-.3-.3-.288-.7t.288-.7q.3-.3.713-.312t.712.287L11 12.15V5q0-.425.288-.712T12 4t.713.288T13 5v7.15l1.875-1.875q.3-.3.713-.288t.712.313q.275.3.288.7t-.288.7l-3.6 3.6q-.15.15-.325.213t-.375.062M6 20q-.825 0-1.412-.587T4 18v-2q0-.425.288-.712T5 15t.713.288T6 16v2h12v-2q0-.425.288-.712T19 15t.713.288T20 16v2q0 .825-.587 1.413T18 20z'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .ic--round-email {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m-.4 4.25l-7.07 4.42c-.32.2-.74.2-1.06 0L4.4 8.25a.85.85 0 1 1 .9-1.44L12 11l6.7-4.19a.85.85 0 1 1 .9 1.44'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .solar--phone-bold {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='m16.556 12.906l-.455.453s-1.083 1.076-4.038-1.862s-1.872-4.014-1.872-4.014l.286-.286c.707-.702.774-1.83.157-2.654L9.374 2.86C8.61 1.84 7.135 1.705 6.26 2.575l-1.57 1.56c-.433.432-.723.99-.688 1.61c.09 1.587.808 5 4.812 8.982c4.247 4.222 8.232 4.39 9.861 4.238c.516-.048.964-.31 1.325-.67l1.42-1.412c.96-.953.69-2.588-.538-3.255l-1.91-1.039c-.806-.437-1.787-.309-2.417.317'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .fluent--scan-qr-code-24-filled {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='M5.25 4C4.56 4 4 4.56 4 5.25V8a1 1 0 0 1-2 0V5.25A3.25 3.25 0 0 1 5.25 2H8a1 1 0 0 1 0 2zm0 16C4.56 20 4 19.44 4 18.75V16a1 1 0 1 0-2 0v2.75A3.25 3.25 0 0 0 5.25 22H8a1 1 0 1 0 0-2zM20 5.25C20 4.56 19.44 4 18.75 4H16a1 1 0 1 1 0-2h2.75A3.25 3.25 0 0 1 22 5.25V8a1 1 0 1 1-2 0zM18.75 20c.69 0 1.25-.56 1.25-1.25V16a1 1 0 1 1 2 0v2.75A3.25 3.25 0 0 1 18.75 22H16a1 1 0 1 1 0-2zM7 7h3v3H7zm7 3h-4v4H7v3h3v-3h4v3h3v-3h-3zm0 0V7h3v3z'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .material-symbols--history-rounded {
            display: inline-block;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='M12 21q-3.15 0-5.575-1.912T3.275 14.2q-.1-.375.15-.687t.675-.363q.4-.05.725.15t.45.6q.6 2.25 2.475 3.675T12 19q2.925 0 4.963-2.037T19 12t-2.037-4.962T12 5q-1.725 0-3.225.8T6.25 8H8q.425 0 .713.288T9 9t-.288.713T8 10H4q-.425 0-.712-.288T3 9V5q0-.425.288-.712T4 4t.713.288T5 5v1.35q1.275-1.6 3.113-2.475T12 3q1.875 0 3.513.713t2.85 1.924t1.925 2.85T21 12t-.712 3.513t-1.925 2.85t-2.85 1.925T12 21m1-9.4l2.5 2.5q.275.275.275.7t-.275.7t-.7.275t-.7-.275l-2.8-2.8q-.15-.15-.225-.337T11 11.975V8q0-.425.288-.712T12 7t.713.288T13 8z'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .fontisto--male {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 22 24'%3E%3Cpath fill='%23000' d='M14.145 16.629a24 24 0 0 1-.052-2.525l-.001.037a4.85 4.85 0 0 0 1.333-2.868l.002-.021c.339-.028.874-.358 1.03-1.666a1.22 1.22 0 0 0-.455-1.218l-.003-.002c.552-1.66 1.698-6.796-2.121-7.326C13.485.35 12.479 0 11.171 0c-5.233.096-5.864 3.951-4.72 8.366a1.22 1.22 0 0 0-.455 1.229l-.001-.008c.16 1.306.691 1.638 1.03 1.666a4.86 4.86 0 0 0 1.374 2.888a25 25 0 0 1-.058 2.569l.005-.081C7.308 19.413.32 18.631 0 24h22.458c-.322-5.369-7.278-4.587-8.314-7.371z'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .fontisto--famale {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 22 24'%3E%3Cpath fill='%23000' d='M14.041 16.683a15 15 0 0 1-.035-.72c2.549-.261 4.338-.872 4.338-1.585c-.007 0-.006-.03-.006-.041C16.432 12.619 19.99.417 13.367.663a3.34 3.34 0 0 0-2.196-.664h.008C2.208.677 6.175 12.202 4.13 14.377h-.004c.008.698 1.736 1.298 4.211 1.566c-.007.17-.022.381-.054.734C7.256 19.447.321 18.671.001 24h22.294c-.319-5.33-7.225-4.554-8.253-7.317z'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .gg--close-o {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cg fill='%23000'%3E%3Cpath d='M16.34 9.322a1 1 0 1 0-1.364-1.463l-2.926 2.728L9.322 7.66A1 1 0 0 0 7.86 9.024l2.728 2.926l-2.927 2.728a1 1 0 1 0 1.364 1.462l2.926-2.727l2.728 2.926a1 1 0 1 0 1.462-1.363l-2.727-2.926z'/%3E%3Cpath fill-rule='evenodd' d='M1 12C1 5.925 5.925 1 12 1s11 4.925 11 11s-4.925 11-11 11S1 18.075 1 12m11 9a9 9 0 1 1 0-18a9 9 0 0 1 0 18' clip-rule='evenodd'/%3E%3C/g%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .material-symbols--logout-rounded {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6q.425 0 .713.288T12 4t-.288.713T11 5H5v14h6q.425 0 .713.288T12 20t-.288.713T11 21zm12.175-8H10q-.425 0-.712-.288T9 12t.288-.712T10 11h7.175L15.3 9.125q-.275-.275-.275-.675t.275-.7t.7-.313t.725.288L20.3 11.3q.3.3.3.7t-.3.7l-3.575 3.575q-.3.3-.712.288t-.713-.313q-.275-.3-.262-.712t.287-.688z'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .bx--image {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Ccircle cx='7.499' cy='9.5' r='1.5' fill='%23000'/%3E%3Cpath fill='%23000' d='m10.499 14l-1.5-2l-3 4h12l-4.5-6z'/%3E%3Cpath fill='%23000' d='M19.999 4h-16c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2m-16 14V6h16l.002 12z'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .eva--save-outline {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='m20.12 8.71l-4.83-4.83A3 3 0 0 0 13.17 3H6a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-7.17a3 3 0 0 0-.88-2.12M10 19v-2h4v2Zm9-1a1 1 0 0 1-1 1h-2v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3H6a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h2v5a1 1 0 0 0 1 1h4a1 1 0 0 0 0-2h-3V5h3.17a1.05 1.05 0 0 1 .71.29l4.83 4.83a1 1 0 0 1 .29.71Z'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .ic--round-date-range {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='M19 4h-1V3c0-.55-.45-1-1-1s-1 .45-1 1v1H8V3c0-.55-.45-1-1-1s-1 .45-1 1v1H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m0 15c0 .55-.45 1-1 1H6c-.55 0-1-.45-1-1V9h14zM7 11h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2z'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .lets-icons--out {
            display: inline-block;
            width: 18px;
            height: 18px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cg fill='none'%3E%3Cpath fill='%23000' d='M3 3V2H2v1zm9.293 10.707a1 1 0 0 0 1.414-1.414zM4 11V3H2v8zM3 4h8V2H3zm-.707-.293l10 10l1.414-1.414l-10-10z'/%3E%3Cpath stroke='%23000' stroke-linecap='round' stroke-width='2' d='M4 15v0c0 1.87 0 2.804.402 3.5A3 3 0 0 0 5.5 19.598C6.196 20 7.13 20 9 20h5c2.828 0 4.243 0 5.121-.879C20 18.243 20 16.828 20 14V9c0-1.87 0-2.804-.402-3.5A3 3 0 0 0 18.5 4.402C17.804 4 16.87 4 15 4v0'/%3E%3C/g%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .lets-icons--in {
            display: inline-block;
            width: 18px;
            height: 18px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cg fill='none'%3E%3Cpath stroke='%23000' stroke-linecap='round' stroke-width='2' d='M3 9v6c0 2.828 0 4.243.879 5.121C4.757 21 6.172 21 9 21h6c2.828 0 4.243 0 5.121-.879C21 19.243 21 17.828 21 15V9c0-2.828 0-4.243-.879-5.121C19.243 3 17.828 3 15 3H9'/%3E%3Cpath fill='%23000' d='M15 15v1h1v-1zM7.707 6.293a1 1 0 0 0-1.414 1.414zM14 8v7h2V8zm1 6H8v2h7zm.707.293l-8-8l-1.414 1.414l8 8z'/%3E%3C/g%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .iconamoon--scanner-fill {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' fill-rule='evenodd' d='M15 4a1 1 0 0 1 1-1h2a3 3 0 0 1 3 3v2a1 1 0 1 1-2 0V6a1 1 0 0 0-1-1h-2a1 1 0 0 1-1-1M3 12a1.5 1.5 0 0 1 1.5-1.5h15a1.5 1.5 0 0 1 0 3h-15A1.5 1.5 0 0 1 3 12m5 9a1 1 0 0 0 0-2H6a1 1 0 0 1-1-1v-2a1 1 0 1 0-2 0v2a3 3 0 0 0 3 3zm12-6a1 1 0 0 1 1 1v2a3 3 0 0 1-3 3h-2a1 1 0 0 1 0-2h2a1 1 0 0 0 1-1v-2a1 1 0 0 1 1-1M3 8a1 1 0 0 0 2 0V6a1 1 0 0 1 1-1h2a1 1 0 1 0 0-2H6a3 3 0 0 0-3 3z' clip-rule='evenodd'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .mdi--video-off {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='M3.27 2L2 3.27L4.73 6H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h12c.2 0 .39-.08.54-.18L19.73 21L21 19.73M21 6.5l-4 4V7a1 1 0 0 0-1-1H9.82L21 17.18z'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .hugeicons--champion {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cg fill='none' stroke='%23000' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' color='%23000'%3E%3Cpath d='M12 17c-1.674 0-3.13 1.265-3.882 3.131c-.36.892.156 1.869.84 1.869h6.083c.685 0 1.2-.977.841-1.869C15.13 18.265 13.674 17 12 17m6.5-12h1.202c1.201 0 1.801 0 2.115.377c.313.378.183.944-.078 2.077l-.39 1.7C20.76 11.708 18.61 13.608 16 14M5.5 5H4.298c-1.201 0-1.802 0-2.115.377c-.313.378-.183.944.078 2.077l.39 1.7C3.24 11.708 5.39 13.608 8 14'/%3E%3Cpath d='M12 17c3.02 0 5.565-4.662 6.33-11.01c.211-1.754.317-2.632-.243-3.311S16.622 2 14.813 2H9.187c-1.81 0-2.714 0-3.274.679S5.46 4.236 5.67 5.991C6.435 12.338 8.98 17 12 17'/%3E%3C/g%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .cuida--user-outline {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cg class='user-outline'%3E%3Cg fill='%23000' fill-rule='evenodd' class='Vector' clip-rule='evenodd'%3E%3Cpath d='M12 10a3 3 0 1 0 0-6a3 3 0 0 0 0 6m0 2a5 5 0 1 0 0-10a5 5 0 0 0 0 10m-7.361 3.448C5.784 13.93 7.509 13 9.714 13h4.572c2.205 0 3.93.93 5.075 2.448C20.482 16.935 21 18.916 21 21a1 1 0 1 1-2 0c0-1.782-.446-3.3-1.235-4.348C17 15.638 15.867 15 14.285 15h-4.57c-1.582 0-2.715.638-3.48 1.652C5.445 17.7 5 19.218 5 21a1 1 0 1 1-2 0c0-2.084.518-4.065 1.639-5.552'/%3E%3Cpath d='M3 21a1 1 0 0 1 1-1h15.962a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .tabler--school {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cg fill='none' stroke='%23000' stroke-linecap='round' stroke-linejoin='round' stroke-width='2'%3E%3Cpath d='M22 9L12 5L2 9l10 4zv6'/%3E%3Cpath d='M6 10.6V16a6 3 0 0 0 12 0v-5.4'/%3E%3C/g%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .lucide--menu {
            display: inline-block;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='none' stroke='%23000' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 12h16M4 6h16M4 18h16'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }

        .cuida--users-outline {
            display: inline-block;
            width: 24px;
            height: 24px;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cg class='users-outline'%3E%3Cg fill='%23000' fill-rule='evenodd' class='Vector' clip-rule='evenodd'%3E%3Cpath d='M8.75 9.5a1.75 1.75 0 1 0 0-3.5a1.75 1.75 0 0 0 0 3.5m0 2a3.75 3.75 0 1 0 0-7.5a3.75 3.75 0 0 0 0 7.5m-5.484 3.027c.899-1.249 2.269-2.027 4.02-2.027h3.428c1.752 0 3.121.778 4.02 2.027C15.607 15.74 16 17.339 16 19a1 1 0 1 1-2 0c0-1.377-.33-2.527-.89-3.305c-.533-.742-1.307-1.195-2.396-1.195H7.286c-1.09 0-1.863.453-2.397 1.195C4.33 16.472 4 17.623 4 19a1 1 0 1 1-2 0c0-1.661.393-3.26 1.266-4.473'/%3E%3Cpath d='M2 19a1 1 0 0 1 1-1h11.971a1 1 0 0 1 0 2H3a1 1 0 0 1-1-1M14.892 5.867l-.028-.002a2.3 2.3 0 0 1-.445-.07c-.345-.092-.655-.276-.796-.595l-.013-.028c-.208-.47.006-1.033.513-1.12a3.75 3.75 0 1 1 .596 7.448c-.514-.004-.815-.526-.684-1.023l.008-.03c.088-.338.366-.569.69-.714a2.3 2.3 0 0 1 .456-.147a1.887 1.887 0 0 0-.297-3.719M15.5 13.5a1 1 0 0 1 1-1h.214c1.752 0 3.121.778 4.02 2.027C21.607 15.74 22 17.339 22 19a1 1 0 1 1-2 0c0-1.377-.33-2.527-.89-3.305c-.533-.742-1.307-1.195-2.396-1.195H16.5a1 1 0 0 1-1-1'/%3E%3Cpath d='M17 19a1 1 0 0 1 1-1h2.971a1 1 0 0 1 0 2H18a1 1 0 0 1-1-1'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }
    </style>

</head>



<body class="hedvig-letters-sans-regular tracking-wide overflow-hidden bg-gray-100">

    {{-- guest layout --}}
    @if (Request::routeIs('show.login*') || Request::routeIs('show.register*'))
        <main class="container max-w-screen-xl mx-auto">
            <div class="md:!grid md:!grid-cols-12 h-[calc(100vh)] w-full overflow-auto">
                <section class="md:col-span-8 md:h-[calc(100vh)] w-full bg-white">
                    {{ $slot }}
                </section>

                <section class="md:col-span-4 md:h-[calc(100vh)] w-full h-[calc(100vh-50%)] md:sticky md:top-0">
                    @if (Request::routeIs('show.register'))
                        <x-form.option imgPath="register.png" title="Have an account?" routePath="show.login"
                            desc="Stay on top of your schedule!" btnLabel="Login here." />

                        {{-- register button --}}
                    @elseif (Request::routeIs('show.login'))
                        <x-form.option imgPath="login.png" title="New Intern?" routePath="show.register"
                            desc="Sign up to keep track of your daily attendance." btnLabel="Register here." />
                    @endif
            </div>
        </main>

        {{-- users/intern layout --}}
    @elseif (Request::routeIs('users.dashboard*') ||
            Request::routeIs('users.settings*') ||
            Request::routeIs('users.dtr*') ||
            Request::routeIs('users.request*'))
        {{-- <div class="w-full h-auto">
            <nav class="bg-white shadow-md fixed top-0 left-0 w-full z-50">
                <div class="lg:hidden flex items-center justify-between gap-5 px-5 py-3">
                    <x-logo width="w-[200px]" />
                    <button id="intern-menu-toggle" class="p-2 border rounded-md">
                        ☰
                    </button>
                </div>

                <div class="hidden lg:grid grid-cols-3 text-nowrap h-auto px-10 border shadow-md">
                    <section class="flex items-center justify-start">
                        <x-logo />
                    </section>
                    <section class="flex items-center justify-center">
                        <a href="{{ route('users.dashboard') }}"
                            class="{{ Request::routeIs('users.dashboard*') ? 'border-[#F53C11] text-[#F53C11] py-10 px-7 border-b-4 flex items-center gap-2 font-semibold' : 'text-gray-600 border-white cursor-pointer font-semibold py-8 px-7 border-b-4 flex items-center gap-2' }}">
                            <span class="akar-icons--dashboard"></span>
                            <p>Dashboard</p>
                        </a>
                        <a href="{{ route('users.dtr') }}"
                            class="{{ Request::routeIs('users.dtr*') ? 'border-[#F53C11] text-[#F53C11] py-10 px-7 border-b-4 flex items-center gap-2 font-semibold' : 'text-gray-600 border-white cursor-pointer font-semibold py-8 px-7 border-b-4 flex items-center gap-2' }}">
                            <span class="mingcute--paper-line"></span>
                            <p>DTR</p>
                        </a>
                        <a href="{{ route('users.settings') }}"
                            class="{{ Request::routeIs('users.settings') ? 'border-[#F53C11] text-[#F53C11] py-10 px-7 border-b-4 flex items-center gap-2 font-semibold' : 'text-gray-600 border-white cursor-pointer font-semibold py-8 px-7 border-b-4 flex items-center gap-2' }}">
                            <span class="solar--settings-linear"></span>
                            <p>Settings</p>
                        </a>
                    </section>
                    <x-form.container routeName="logout" className="flex items-center justify-end">
                        @csrf
                        <button
                            class="flex items-center opacity-100 gap-1 w-fit px-8 py-3 rounded-lg font-semibold bg-[#F53C11] hover:bg-[#F53C11]/80 text-white animate-transition"><span
                                class="material-symbols--logout-rounded"></span>Logout</button>
                    </x-form.container>
                </div>
            </nav>

            <aside id="mobile-menu"
                class="fixed top-[69px] right-0 mt-1 w-64 h-[calc(100vh-3rem)] bg-white shadow-md transform translate-x-full transition-transform lg:hidden overflow-auto z-50 flex flex-col justify-between">
                <nav>
                    <a href="{{ route('users.dashboard') }}"
                        class="{{ Request::routeIs('users.dashboard*') ? 'border-[#F53C11] text-[#F53C11] py-5 px-7 border-l-4 flex items-center gap-2 font-semibold' : 'text-gray-600 border-white cursor-pointer font-semibold py-5 px-7 border-l-4 flex items-center gap-2' }}">
                        <span class="akar-icons--dashboard"></span>
                        <p>Dashboard</p>
                    </a>
                    <a href="{{ route('users.dtr') }}"
                        class="{{ Request::routeIs('users.dtr*') ? 'border-[#F53C11] text-[#F53C11] py-5 px-7 border-l-4 flex items-center gap-2 font-semibold' : 'text-gray-600 border-white cursor-pointer font-semibold py-5 px-7 border-l-4 flex items-center gap-2' }}">
                        <span class="mingcute--paper-line"></span>
                        <p>DTR</p>
                    </a>
                    <a href="{{ route('users.settings') }}"
                        class="{{ Request::routeIs('users.settings*') ? 'border-[#F53C11] text-[#F53C11] py-5 px-7 border-l-4 flex items-center gap-2 font-semibold' : 'text-gray-600 border-white cursor-pointer font-semibold py-5 px-7 border-l-4 flex items-center gap-2' }}">
                        <span class="solar--settings-linear"></span>
                        <p>Settings</p>
                    </a>
                </nav>

                <x-form.container routeName="logout" className="flex items-center justify-center">
                    @csrf
                    <button
                        class="flex items-center opacity-100 gap-1 w-full px-8 py-5 font-semibold bg-[#F53C11] hover:bg-[#F53C11]/80 text-white animate-transition"><span
                            class="material-symbols--logout-rounded"></span>Logout</button>
                </x-form.container>
            </aside>

            <main class="lg:!mt-[110px] mt-[73px] bg-gray-100">
                {{ $slot }}
            </main>
        </div> --}}

        {{-- <main class="container max-w-screen-xl mx-auto"> --}}
            <div class="h-full w-full lg:grid lg:grid-cols-12">
                <section class="sticky lg:hidden top-0 w-full bg-white shadow-md h-auto py-4 z-50">
                    <div class="flex items-center justify-between w-full lg:px-10 px-5 gap-5">
                        <section class="grid grid-cols-3 w-full">
                            <div class="col-span-1 flex items-center justify-start w-full">
                                <button id="intern-menu-toggle" class="lg:hidden p-2 border rounded-md w-fit h-fit">
                                    ☰
                                </button>
                            </div>
                            <div class="col-span-1 w-full flex items-center justify-center">
                                <x-logo />
                            </div>
                        </section>
                    </div>
                </section>

                @php
                    $profile = \App\Models\Profile::where('id', Auth::user()->profile_id)->first();
                    $file = \App\Models\File::where('id', $profile->file_id)->first();
                @endphp

            <!-- Sidebar Menu (Hidden on Large Screens) -->
                <aside id="mobile-menu"
                    class="fixed top-22 left-0 mt-0 w-64 h-[calc(100vh-4rem)] bg-white shadow-md transform -translate-x-full transition-transform lg:hidden overflow-auto z-50 flex flex-col justify-between py-5">

                    <nav class="w-full flex flex-col gap-10">
                        <section class="w-full flex flex-col gap-2 justify-center items-center px-7">
                            <div class="w-auto h-auto">
                                {{-- <x-image path="resources/img/default-male.png"
                                    className="h-24 w-24 shadow-md border border-[#F57D11] rounded-full" /> --}}
                                    <div class="h-24 w-24 shadow-md border border-[#F57D11] rounded-full overflow-hidden">
                                        <x-image path="{{$file->path . '?t=' . time()}}"
                                            className="h-full w-full" />
                                    </div>
                            </div>
                            <h1 class="font-bold text-lg capitalize text-center text-ellipsis">
                                {{ Auth::user()->firstname }}
                                {{ substr(Auth::user()->middlename, 0, 1) }}. {{ Auth::user()->lastname }}</h1>
                            <p class="text-[#F53C11] text-center -mt-2">{{ Auth::user()->email }}</p>

                        </section>

                        <section class="w-full border-y border-gray-100 py-5">
                            <x-sidebar-menu route="users.dashboard">
                                <span class="akar-icons--dashboard"></span>
                                <p>Dashboard</p>
                            </x-sidebar-menu>
                            <x-sidebar-menu route="users.dtr">
                                <span class="mingcute--paper-line"></span>
                                <p>DTR</p>
                            </x-sidebar-menu>
                            <x-sidebar-menu route="users.request">
                                <span class="ph--hand-deposit"></span>
                                <p>Request</p>
                            </x-sidebar-menu>
                            <x-sidebar-menu route="users.settings">
                                <span class="solar--settings-linear"></span>
                                <p>Settings</p>
                            </x-sidebar-menu>
                        </section>
                    </nav>

                    <section class="pt-5 w-full">
                        <x-form.container routeName="logout" className="flex items-center justify-center">
                            @csrf
                            <button
                                class="flex items-center opacity-100 gap-1 w-full px-8 py-5 font-semibold bg-[#F53C11] hover:bg-[#F53C11]/80 text-white animate-transition"><span
                                    class="material-symbols--logout-rounded"></span>Logout</button>
                        </x-form.container>
                    </section>
                </aside>

                <!-- Left Sidebar (Sticky on Large Screens) -->
                <aside
                    class="hidden lg:flex flex-col justify-between items-center col-span-3 bg-white shadow-xl sticky top-0 h-[calc(100vh)] overflow-auto py-5">

                    <nav class="w-full flex flex-col gap-10">

                        <div class="px-7 pt-5 w-full flex justify-center">
                            <x-logo />
                        </div>
                        
                        <section class="w-full flex flex-col gap-2 justify-center items-center px-7">
                            <div class="w-auto h-auto">
                                <div class="h-32 w-32 shadow-md border border-[#F57D11] rounded-full overflow-hidden">
                                    <x-image path="{{$file->path . '?t=' . time()}}"
                                        className="w-full h-full" />
                                </div>
                            </div>
                            <h1 class="font-bold text-lg capitalize text-center text-ellipsis">
                                {{ Auth::user()->firstname }}
                                {{ substr(Auth::user()->middlename, 0, 1) }}. {{ Auth::user()->lastname }}</h1>
                            <p class="text-[#F53C11] text-center -mt-2">{{ Auth::user()->email }}</p>

                        </section>

                        <section class="w-full border-y border-gray-100 py-5">
                            <x-sidebar-menu route="users.dashboard">
                                <span class="akar-icons--dashboard"></span>
                                <p>Dashboard</p>
                            </x-sidebar-menu>
                            <x-sidebar-menu route="users.dtr">
                                <span class="mingcute--paper-line"></span>
                                <p>DTR</p>
                            </x-sidebar-menu>
                            <x-sidebar-menu route="users.request">
                                <span class="ph--hand-deposit"></span>
                                <p>Request</p>
                            </x-sidebar-menu>
                            <x-sidebar-menu route="users.settings">
                                <span class="solar--settings-linear"></span>
                                <p>Settings</p>
                            </x-sidebar-menu>
                        </section>
                    </nav>

                    <section class="pt-5 w-full">
                        <x-form.container routeName="logout" className="flex items-center justify-center">
                            @csrf
                            <button
                                class="flex items-center opacity-100 gap-1 w-full px-8 py-5 font-semibold bg-[#F53C11] hover:bg-[#F53C11]/80 text-white animate-transition"><span
                                    class="material-symbols--logout-rounded"></span>Logout</button>
                        </x-form.container>
                    </section>
                </aside>

                <!-- Main Content (Auto Scroll) -->
                <main
                    class="col-span-9 overflow-auto w-full lg:!h-[calc(100vh)] h-[calc(100vh-4rem)] bg-gray-100 lg:!p-10 p-5">
                    {{ $slot }}
                </main>
            </div>
        </main>

        <script>
            const menuToggle = document.getElementById("intern-menu-toggle");
            const mobileMenu = document.getElementById("mobile-menu");

            menuToggle.addEventListener("click", () => {
                mobileMenu.classList.toggle("-translate-x-full");
            });

            // swiper
            var swiper = new Swiper(".progress-slide-carousel", {
                loop: true,
                fraction: true,
                autoplay: {
                    delay: 1200,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".progress-slide-carousel .swiper-pagination",
                    type: "progressbar",
                },
            });

            document.addEventListener("DOMContentLoaded", function() {
                const dropdownToggle = document.getElementById("dropdown-toggle");
                const dropdownMenu = document.getElementById("dropdown-menu");

                // Toggle dropdown visibility on button click
                dropdownToggle.addEventListener("click", function() {
                    dropdownMenu.classList.toggle("hidden");
                });

                // Close dropdown when clicking outside
                document.addEventListener("click", function(event) {
                    if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                        dropdownMenu.classList.add("hidden");
                    }
                });
            });
        </script>

         {{-- admin layout --}}
    @elseif (Request::routeIs('admin.dashboard*') ||
        Request::routeIs('admin.users*') ||
        Request::routeIs('admin.histories*') ||
        Request::routeIs('admin.profile*') ||
        Request::routeIs('admin.schools*') ||
        Request::routeIs('admin.approvals*'))
        @props(['array_daily' => '', 'ranking' => ''])

    <main class="container max-w-screen-xl mx-auto">
        <div class="h-full w-full lg:grid lg:grid-cols-12">

            <!-- Sidebar Menu (Hidden on Large Screens) -->
            <aside id="mobile-menu"
                class="fixed top-22 left-0 mt-20 w-64 h-[calc(100vh-5rem)] bg-white shadow-md transform -translate-x-full transition-transform lg:hidden overflow-auto z-50">
                <div class="px-5 pt-7 w-full">
                    <x-logo />
                </div>
                <nav class="mt-5">
                    <x-sidebar-menu route="admin.dashboard">
                        <div class="w-auto h-auto flex items-center"><span class="akar-icons--dashboard"></span>
                        </div>
                        <p>Dashboard</p>
                    </x-sidebar-menu>
                    <x-sidebar-menu route="admin.approvals">
                        <div class="w-auto h-auto flex items-center"><span class="lucide--check-check"></span>
                        </div>
                        <p>Approvals</p>
                    </x-sidebar-menu>
                    <x-sidebar-menu route="admin.users">
                        <div class="w-auto h-auto flex items-center"><span class="cuida--users-outline"></span>
                        </div>
                        <p>Users</p>
                    </x-sidebar-menu>
                    <x-sidebar-menu route="admin.histories">
                        <div class="w-auto h-auto flex items-center"><span
                                class="material-symbols--history-rounded w-6 h-6"></span></div>
                        <p>History</p>
                    </x-sidebar-menu>
                    <x-sidebar-menu route="admin.schools">
                        <div class="w-auto h-auto flex items-center"><span
                                class="material-symbols--school-outline-rounded !w-6 !h-6"></span></div>
                        <p>Schools</p>
                    </x-sidebar-menu>
                    <x-sidebar-menu route="admin.profile">
                        <div class="w-auto h-auto flex items-center"><span class="cuida--user-outline"></span>
                        </div>
                        <p>Profile</p>
                    </x-sidebar-menu>
                </nav>
            </aside>

            <!-- Left Sidebar (Sticky on Large Screens) -->
            <aside
                class="hidden lg:block col-span-2 bg-white shadow-xl sticky top-0 h-[calc(100vh)] overflow-auto py-5">
                <div class="px-5 w-full">
                    <x-logo />
                </div>
                <!-- Navigation -->
                <nav class="mt-10">
                    <x-sidebar-menu route="admin.dashboard">
                        <div class="w-auto h-auto flex items-center"><span class="akar-icons--dashboard"></span>
                        </div>
                        <p>Dashboard</p>
                    </x-sidebar-menu>
                    <x-sidebar-menu route="admin.approvals">
                        <div class="w-auto h-auto flex items-center"><span class="lucide--check-check"></span>
                        </div>
                        <p>Approvals</p>
                    </x-sidebar-menu>
                    <x-sidebar-menu route="admin.users">
                        <div class="w-auto h-auto flex items-center"><span class="cuida--users-outline"></span>
                        </div>
                        <p>Users</p>
                    </x-sidebar-menu>
                    <x-sidebar-menu route="admin.histories">
                        <div class="w-auto h-auto flex items-center"><span
                                class="material-symbols--history-rounded w-6 h-6"></span></div>
                        <p>History</p>
                    </x-sidebar-menu>
                    <x-sidebar-menu route="admin.schools">
                        <div class="w-auto h-auto flex items-center"><span
                                class="material-symbols--school-outline-rounded !w-6 !h-6"></span></div>
                        <p>Schools</p>
                    </x-sidebar-menu>
                    <x-sidebar-menu route="admin.profile">
                        <div class="w-auto h-auto flex items-center"><span class="cuida--user-outline"></span>
                        </div>
                        <p>Profile</p>
                    </x-sidebar-menu>
                </nav>
            </aside>

            <!-- Main Content (Auto Scroll) -->
            <main class="col-span-10 overflow-auto w-full h-[calc(100vh)] bg-gray-100">
                <section class="sticky top-0 w-full bg-white shadow-md h-auto py-4 z-50">
                    <div class="flex items-center justify-between w-full lg:px-10 px-5 gap-5">
                        <section class="flex items-center gap-4">
                            <button id="menu-toggle" class="lg:hidden p-2 border rounded-md">
                                ☰
                            </button>
                            @if (Request::routeIs('admin.dashboard*'))
                                <x-page-title title="Dashboard" />
                            @elseif (Request::routeIs('admin.approvals*'))
                                <x-page-title title="Approvals" />
                            @elseif (Request::routeIs('admin.users*'))
                                <x-page-title title="Users" />
                            @elseif (Request::routeIs('admin.histories*'))
                                <x-page-title title="History" />
                            @elseif (Request::routeIs('admin.schools*'))
                                <x-page-title title="Schools" />
                            @elseif (Request::routeIs('admin.profile*'))
                                <x-page-title title="Profile" />
                            @endif
                        </section>

                        <section class="flex items-center gap-2">
                            <div class="dropdown relative inline-flex self-center">
                                <button type="button" id="dropdown-notification"
                                    class="dropdown-notification w-10 h-10 relative text-gray-500 p-2 rounded-full hover:bg-gray-100 cursor-pointer">
                                    <span class="mi--notification w-full h-full relative"></span>
                                    @if ($notifications->where('is_read', 0)->count())
                                        {{-- <div
                                            class="absolute top-0 right-0 w-5 h-5 rounded-full bg-[#F53C11] p-1 text-center flex items-center justify-center text-white">
                                            <span
                                                class="text-[10px] font-semibold m-auto">{{ $notifications->where('is_read', 0)->count() }}</span>
                                        </div> --}}
                                        <div class="absolute top-0 right-0">
                                            <div
                                                class=" w-5 h-5 rounded-full bg-[#F53C11] p-1 text-center flex items-center justify-center text-white">
                                                <p class="text-[10px] font-semibold">
                                                    {{ $notifications->where('is_read', 0)->count() }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </button>

                                <div id="dropdown-show-notification"
                                    class="dropdown-menu-notification hidden rounded-lg shadow-lg border border-gray-300 bg-white absolute top-full lg:-right-40 -right-20 mt-2 md:w-[600px] sm:w-[400px] w-[300px] z-20">

                                    <!-- Header -->
                                    <div class="px-4 py-3 flex justify-between items-center text-[#F57D11]">
                                        <h2 class="text-base font-semibold">
                                            Notifications <span id="notification-count">
                                                @if ($notifications->where('is_read', 0)->count() != 0)
                                                    ({{ count($notifications->where('is_read', 0)) }})
                                                @endif
                                            </span>
                                        </h2>
                                    </div>

                                    <!-- Tabs -->
                                    <div class="flex border-b text-sm">
                                        <button id="tab-all"
                                            class="tab-btn px-4 py-2 text-[#F57D11] border-[#F57D11] font-semibold border-b-2">
                                            All @if ($notifications->where('is_archive', 0)->count() != 0)
                                                ({{ $notifications->where('is_archive', 0)->count() }})
                                            @endif
                                        </button>
                                        <button id="tab-unread" class="tab-btn px-4 py-2 text-gray-500">
                                            Unread @if ($notifications->where('is_read', 0)->where('is_archive', 0)->count() != 0)
                                                ({{ $notifications->where('is_read', 0)->where('is_archive', 0)->count() }})
                                            @endif
                                        </button>
                                        <button id="tab-archived" class="tab-btn px-4 py-2 text-gray-500">
                                            Archived @if ($notifications->where('is_archive', 1)->count() != 0)
                                                ({{ $notifications->where('is_archive', 1)->count() }})
                                            @endif
                                        </button>
                                    </div>

                                    <!-- All Notifications -->
                                    <section id="tab-content-all"
                                        class="divide-y divide-gray-100 w-full h-60 overflow-auto">
                                        @forelse ($notifications->where('is_archive', 0) as $notification)
                                            <div class="flex items-center justify-between gap-5 p-3 w-full cursor-pointer 
    hover:bg-gray-50 {{ $notification->is_read ? 'bg-white' : 'bg-gray-100' }}"
                                                onclick="openAllNotificationModal({{ $notification->id }}, '{{ addslashes($notification->message) }}', {{ $notification->is_read ? 'true' : 'false' }}, 'tab-all')">

                                                <div class="flex items-center gap-3 w-2/3">
                                                    <div class="w-auto h-auto">
                                                        <div class="w-10 h-10 rounded-full border border-[#F57D11] overflow-hidden">
                                                            <x-image path="resources/img/default-male.png"
                                                            className="w-full h-full" />
                                                        </div>
                                                    </div>
                                                    <div class="w-full truncate">
                                                        <p class="text-sm font-semibold truncate">
                                                            {{ $notification->message }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 truncate">
                                                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="flex items-center space-x-2">
                                                    <div class="relative group">
                                                        <button
                                                            class="decline-btn px-2 py-1 bg-gray-400 hover:bg-black text-white rounded flex items-center justify-center gap-1"
                                                            onclick="event.stopPropagation(); archiveNotification({{ $notification->id }})">
                                                            <span
                                                                class="material-symbols--archive-rounded w-4 h-4"></span>
                                                            <span
                                                                class="text-black absolute -top-4 opacity-0 group-hover:opacity-100 animate-transition text-[11px] font-semibold ">
                                                                Archive
                                                            </span>
                                                        </button>
                                                    </div>
                                                    @if (!$notification->is_read)
                                                        <span class="bg-[#F57D11] w-2 h-2 rounded-full"></span>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <div
                                                class="w-full h-full flex justify-center items-center text-gray-600 text-sm">
                                                Nothing to see here.
                                            </div>
                                        @endforelse

                                        <div id="AllNotificationModal"
                                            class="w-full h-full fixed top-0 left-0 z-[100] flex items-center justify-center  overflow-x-hidden overflow-y-auto bg-black bg-opacity-70 hidden transition ease-in duration-500">
                                            <div
                                                class="lg:!w-1/3 md:w-1/2 w-full flex flex-col p-10 gap-5 bg-white rounded-2xl transition ease-in duration-500">
                                                <div class="flex w-full flex-col items-start gap-3 text-wrap">
                                                    <x-page-title title="Approval Request" titleClass="text-xl" />
                                                    <p id="allNotificationMessage"
                                                        class="text-gray-800 w-full text-wrap">
                                                    <p class="text-sm font-semibold text-gray-600">Requested DTR:
                                                        <span id="DateNotificationMessage"
                                                            class="text-[#F57D11] font-semibold text-base">date
                                                            here</span>
                                                    </p>
                                                    {{-- <p id="dateMessage" class="mt-2 text-gray-600 w-full text-wrap">
                                                    date here
                                                </p> --}}
                                                    <div class="flex gap-3 items-center justify-end w-full mt-2">
                                                        <x-button onClick="showNotificationModal()" label="View"
                                                            className="!px-8" tertiary button />
                                                        <x-button onClick="closeAllNotificationModal()"
                                                            label="Close" className="!px-8" primary button />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <!-- Unread Notifications -->
                                    <section id="tab-content-unread"
                                        class="hidden divide-y divide-gray-100 w-full h-60 overflow-auto">
                                        @forelse ($notifications->where('is_read', 0)->where('is_archive', 0) as $notification)
                                            <div class="flex items-center justify-between gap-5 p-3 w-full cursor-pointer 
    hover:bg-gray-50 {{ $notification->is_read ? 'bg-white' : 'bg-gray-100' }}"
                                                onclick="openUnreadNotificationModal({{ $notification->id }}, '{{ addslashes($notification->message) }}', {{ $notification->is_read ? 'true' : 'false' }}, 'tab-unread')">
                                                <div class="flex items-center gap-3 w-2/3">
                                                    <div class="w-auto h-auto">
                                                        <div class="w-10 h-10 rounded-full border border-[#F57D11] overflow-hidden">
                                                            <x-image path="resources/img/default-male.png"
                                                            className="h-full w-full" />
                                                        </div>
                                                    </div>  
                                                    <div class="w-full truncate">
                                                        <p class="text-sm font-semibold truncate">
                                                            {{ $notification->message }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 truncate">
                                                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="flex items-center space-x-2">
                                                    <div class="relative group">
                                                        <button
                                                            class="decline-btn px-2 py-1 bg-gray-400 hover:bg-black text-white rounded flex items-center justify-center gap-1"
                                                            onclick="event.stopPropagation(); archiveNotification({{ $notification->id }})">
                                                            <span
                                                                class="material-symbols--archive-rounded w-4 h-4"></span>
                                                            <span
                                                                class="text-black absolute -top-4 opacity-0 group-hover:opacity-100 animate-transition text-[11px] font-semibold ">
                                                                Archive
                                                            </span>
                                                        </button>
                                                    </div>
                                                    @if (!$notification->is_read)
                                                        <span class="bg-[#F57D11] w-2 h-2 rounded-full"></span>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <div
                                                class="w-full h-full flex justify-center items-center text-gray-600 text-sm">
                                                Nothing to see here.
                                            </div>
                                        @endforelse

                                        <div id="UnreadNotificationModal"
                                            class="w-full h-full fixed top-0 left-0 z-[100] flex items-center justify-center  overflow-x-hidden overflow-y-auto bg-black bg-opacity-70 hidden transition ease-in duration-500">
                                            <div
                                                class="lg:!w-1/3 md:w-1/2 w-full flex flex-col p-10 gap-5 bg-white rounded-2xl transition ease-in duration-500">
                                                <div class="flex w-full flex-col items-start gap-3 text-wrap">
                                                    <x-page-title title="Approval Request" titleClass="text-xl" />
                                                    <p id="unreadNotificationMessage"
                                                        class="text-gray-800 w-full text-wrap">
                                                    <p class="text-sm font-semibold text-gray-600">Requested DTR:
                                                        <span id="UnreadDateNotificationMessage"
                                                            class="text-[#F57D11] font-semibold text-base">date
                                                            here</span>
                                                    </p>
                                                    {{-- <p id="dateMessage" class="mt-2 text-gray-600 w-full text-wrap">
                                                    date here
                                                </p> --}}
                                                    <div class="flex gap-3 items-center justify-end w-full mt-2">
                                                        <x-button onClick="showNotificationModal()" label="View"
                                                            className="!px-8" tertiary button />
                                                        <x-button onClick="closeUnreadNotificationModal()"
                                                            label="Close" className="!px-8" primary button />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <!-- Archived Notifications -->
                                    <section id="tab-content-archived"
                                        class="hidden divide-y divide-gray-100 w-full h-60 overflow-auto">
                                        @forelse ($notifications->where('is_archive', 1) as $notification)
                                            <div class="flex items-center justify-between gap-5 p-3 w-full cursor-pointer 
    hover:bg-gray-50 {{ $notification->is_read ? 'bg-white' : 'bg-gray-100' }}"
                                                onclick="openArchiveNotificationModal({{ $notification->id }}, '{{ addslashes($notification->message) }}', {{ $notification->is_read ? 'true' : 'false' }}, 'tab-archive')">
                                                <div class="flex items-center gap-3 w-2/3">
                                                    <div class="h-auto w-auto">
                                                        <div class="w-10 h-10 rounded-full border border-gray-400 overflow-hidden">
                                                            <x-image path="resources/img/default-male.png"
                                                            className="w-full h-full" />
                                                        </div>
                                                    </div>
                                                    <div class="w-full truncate">
                                                        <p class="text-sm font-semibold truncate">
                                                            {{ $notification->message }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 truncate">
                                                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div>
                                                    @if (!$notification->is_read)
                                                        <div class="bg-[#F57D11] w-2 h-2 rounded-full"></div>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <div
                                                class="w-full h-full flex justify-center items-center text-gray-600 text-sm">
                                                Nothing to see here.
                                            </div>
                                        @endforelse
                                    </section>

                                    <div id="ArchiveNotificationModal"
                                        class="w-full h-full fixed top-0 left-0 z-[100] flex items-center justify-center  overflow-x-hidden overflow-y-auto bg-black bg-opacity-70 hidden transition ease-in duration-500">
                                        <div
                                            class="lg:!w-1/3 md:w-1/2 w-full flex flex-col p-10 gap-5 bg-white rounded-2xl transition ease-in duration-500">
                                            <div class="flex w-full flex-col items-start gap-3 text-wrap">
                                                <x-page-title title="Approval Request" titleClass="text-xl" />
                                                <p id="archiveNotificationMessage"
                                                    class="text-gray-800 w-full text-wrap">
                                                <p class="text-sm font-semibold text-gray-600">Requested DTR: <span
                                                        id="ArchiveDateNotificationMessage"
                                                        class="text-[#F57D11] font-semibold text-base">date
                                                        here</span></p>
                                                {{-- <p id="dateMessage" class="mt-2 text-gray-600 w-full text-wrap">
                                                    date here
                                                </p> --}}
                                                <div class="flex gap-3 items-center justify-end w-full mt-2">
                                                    <x-button onClick="showNotificationModal()" label="View"
                                                        className="!px-8" tertiary button />
                                                    <x-button onClick="closeArchiveNotificationModal()"
                                                        label="Close" className="!px-8" primary button />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="dropdown relative inline-flex">
                                <button type="button" id="dropdown-profile" data-target="dropdown-show-profile"
                                    class="dropdown-profile items-center gap-2 hover:bg-gray-100 rounded-lg py-2 px-3 overflow-hidden inline-flex">
                                    <div class="w-auto h-auto">
                                        <div class="w-10 h-10 rounded-full shadow border border-[#F53C11] overflow-hidden">
                                            <x-image path="{{
                                                optional(\App\Models\File::find(optional(\App\Models\Profile::find(Auth::user()->profile_id))->file_id))->path
                                                ?? 'resources/img/default-male.png'
                                            }}"
                                                className="w-full h-full" />
                                        </div>
                                    </div>
                                    <p class="lg:block hidden capitalize">{{ Auth::user()->firstname }}</p>
                                    <span class="iconamoon--arrow-down-2"></span>
                                </button>
                                <div id="dropdown-show-profile"
                                    class="dropdown-menu-profile hidden rounded-lg shadow-lg border border-gray-300 bg-white absolute top-full right-0 w-72 divide-y divide-gray-200">
                                    <ul class="py-2">
                                        <li>
                                            <a class="block px-6 py-2 hover:bg-gray-100 text-gray-900 font-semibold"
                                                href="{{ route('admin.profile') }}"> Profile </a>
                                        </li>
                                    </ul>
                                    <div class="pt-2">
                                        <x-form.container routeName="logout" method="POST" className="w-full">
                                            <x-button label="Logout"
                                                className="px-6 py-2 hover:bg-gray-100 text-[#F53C11] font-semibold w-full text-start"
                                                submit />
                                        </x-form.container>
                                    </div>
                                </div>
                            </div>

                        </section>
                    </div>
                </section>

                <section class="lg:!p-10 p-5">
                    {{ $slot }}
                </section>
            </main>
        </div>
    </main>

    <script>
        const menuToggle = document.getElementById("menu-toggle");
        const mobileMenu = document.getElementById("mobile-menu");

        menuToggle.addEventListener("click", () => {
            mobileMenu.classList.toggle("-translate-x-full");
        });

        // notifications and profile
        document.addEventListener("DOMContentLoaded", function() {
            const dropdownProfile = document.getElementById("dropdown-profile");
            const dropdownMenuProfile = document.getElementById("dropdown-show-profile");

            const dropdownNotification = document.getElementById("dropdown-notification");
            const dropdownMenuNotification = document.getElementById("dropdown-show-notification");

            const closeDropdown = document.getElementById("close-dropdown");

            const tabs = {
                all: document.getElementById("tab-all"),
                unread: document.getElementById("tab-unread"),
                archived: document.getElementById("tab-archived")
            };

            const tabContents = {
                all: document.getElementById("tab-content-all"),
                unread: document.getElementById("tab-content-unread"),
                archived: document.getElementById("tab-content-archived")
            };

            function closeAllDropdowns() {
                dropdownMenuProfile?.classList.add("hidden");
                dropdownMenuNotification?.classList.add("hidden");
            }

            function toggleDropdown(dropdownButton, dropdownMenu, otherDropdownMenu) {
                if (dropdownMenu.classList.contains("hidden")) {
                    closeAllDropdowns(); // Close any open dropdown first
                    dropdownMenu.classList.remove("hidden"); // Open clicked dropdown
                } else {
                    dropdownMenu.classList.add("hidden"); // Close dropdown if already open
                }
            }

            // Toggle profile dropdown
            dropdownProfile?.addEventListener("click", function(event) {
                event.stopPropagation();
                toggleDropdown(dropdownProfile, dropdownMenuProfile, dropdownMenuNotification);
            });

            // Toggle notification dropdown
            dropdownNotification?.addEventListener("click", function(event) {
                event.stopPropagation();
                toggleDropdown(dropdownNotification, dropdownMenuNotification, dropdownMenuProfile);
            });

            closeDropdown?.addEventListener("click", function() {
                closeAllDropdowns();
            });

            // Close dropdown when clicking outside
            document.addEventListener("click", function(event) {
                if (
                    !dropdownProfile?.contains(event.target) &&
                    !dropdownMenuProfile?.contains(event.target) &&
                    !dropdownNotification?.contains(event.target) &&
                    !dropdownMenuNotification?.contains(event.target)
                ) {
                    closeAllDropdowns();
                }
            });

            // Tab switching functionality
            function switchTab(activeTab, activeContent) {
                // Reset all tabs
                Object.values(tabs).forEach(tab => {
                    tab.classList.remove("text-[#F57D11]", "border-[#F57D11]", "font-semibold",
                        "border-b-2");
                    tab.classList.add("text-gray-500");
                });

                Object.values(tabContents).forEach(content => content.classList.add("hidden"));

                // Activate selected tab
                activeTab.classList.add("text-[#F57D11]", "border-[#F57D11]", "font-semibold",
                    "border-b-2");
                activeTab.classList.remove("text-gray-500");

                activeContent.classList.remove("hidden");
            }

            // Set initial active tab to 'All'
            switchTab(tabs.all, tabContents.all);

            // Add event listeners for tab clicks
            Object.keys(tabs).forEach(key => {
                tabs[key].addEventListener("click", function() {
                    switchTab(tabs[key], tabContents[key]);
                });
            });
        });
    </script>
    @else
        {{-- login / register form --}}
        <main class="h-full w-full bg-white">
            {{ $slot }}
        </main>
    @endif
</body>

</html>
<script>
    let notification_id = 0;

//     function openNotificationModal(id, message, isRead, tab) {

//     if (!tab) {
//         console.error("Tab is undefined!");
//         return;
//     }

//     let msgText = message;
//     let dateText = "";

//     let lastIndex = message.lastIndexOf("DTR.");
//     if (lastIndex !== -1) {
//         msgText = message.substring(0, lastIndex + 4);
//         dateText = message.substring(lastIndex + 5).trim();
//     }

//     console.log(`Tab: ${tab}`); // Debugging

//     // Find the modal container
//     const modal = document.getElementById(`${tab}NotificationModal`);
//     if (!modal) {
//         console.error(`Modal ${tab}NotificationModal not found!`);
//         return;
//     }

//     // Find the <p> elements inside the nested divs
//     const messageElement = modal.querySelector(`#${tab}NotificationMessage`);
//     const dateElement = modal.querySelector(`#${tab}DateNotificationMessage`);

//     if (messageElement) {
//         messageElement.innerText = msgText;
//     } else {
//         console.error(`Element ${tab}NotificationMessage not found!`);
//     }

//     if (dateElement) {
//         dateElement.innerText = dateText;
//     } else {
//         console.error(`Element ${tab}DateNotificationMessage not found!`);
//     }

//     // Show the modal
//     modal.classList.remove("hidden");

//     // Mark as read if needed
//     if (!isRead) {
//         markAsRead(id);
//     }
// }

function openAllNotificationModal(notificationId, message, isRead, tab) {
    
    const modal = document.getElementById("AllNotificationModal");
    const messageElement = document.getElementById("allNotificationMessage");
    const dateElement = document.getElementById("DateNotificationMessage");
    
    if (!modal || !messageElement || !dateElement) {
        console.error("Modal elements not found!");
        return;
    }

    let text = message;

    let msgText;
    let dateText;

    // Find the last occurrence of "DTR." and extract the message
    let lastIndex = text.lastIndexOf("DTR.");

    if (lastIndex !== -1) {
        msgText = text.substring(0, lastIndex + 4); // Extracts from first word to "DTR."
        dateText = text.substring(lastIndex + 5).trim(); // Extracts everything after "DTR."
    }

    messageElement.innerText = msgText;
    dateElement.innerText = dateText;    

    
    // Show modal
    modal.classList.remove("hidden");

    if (!isRead) {
        markAsRead(notificationId);
    }
}

function openUnreadNotificationModal(notificationId, message, isRead, tab) {
    
    const modal = document.getElementById("UnreadNotificationModal");
    const messageElement = document.getElementById("unreadNotificationMessage");
    const dateElement = document.getElementById("UnreadDateNotificationMessage");
    
    if (!modal || !messageElement || !dateElement) {
        console.error("Modal elements not found!");
        return;
    }

    let text = message;

    let msgText;
    let dateText;

    // Find the last occurrence of "DTR." and extract the message
    let lastIndex = text.lastIndexOf("DTR.");

    
    if (lastIndex !== -1) {
        msgText = text.substring(0, lastIndex + 4); // Extracts from first word to "DTR."
        dateText = text.substring(lastIndex + 5).trim(); // Extracts everything after "DTR."
    }

    messageElement.innerText = msgText;
    dateElement.innerText = dateText;

    // Show modal
    modal.classList.remove("hidden");

    if (!isRead) {
        markAsRead(notificationId);
    }

}

function openArchiveNotificationModal(notificationId, message, isRead, tab) {
    
    const modal = document.getElementById("ArchiveNotificationModal");
    const messageElement = document.getElementById("archiveNotificationMessage");
    const dateElement = document.getElementById("ArchiveDateNotificationMessage");
    
    if (!modal || !messageElement || !dateElement) {
        console.error("Modal elements not found!");
        return;
    }

    let text = message;

    let msgText;
    let dateText;

    // Find the last occurrence of "DTR." and extract the message
    let lastIndex = text.lastIndexOf("DTR.");

    if (lastIndex !== -1) {
        msgText = text.substring(0, lastIndex + 4); // Extracts from first word to "DTR."
        dateText = text.substring(lastIndex + 5).trim(); // Extracts everything after "DTR."
    }

    messageElement.innerText = msgText;
    dateElement.innerText = dateText;

    // Show modal
    modal.classList.remove("hidden");

    if (!isRead) {
        markAsRead(notificationId);
    }
    
}

function closeAllNotificationModal() {
    const modal = document.getElementById("AllNotificationModal");
    if (modal) {
        modal.classList.add("hidden");
    }
}

function closeUnreadNotificationModal() {
    const modal = document.getElementById("UnreadNotificationModal");
    if (modal) {
        modal.classList.add("hidden");
    }
}

function closeArchiveNotificationModal() {
    const modal = document.getElementById("ArchiveNotificationModal");
    if (modal) {
        modal.classList.add("hidden");
    }
}



    function showNotificationModal() {
        window.location.href = '/admin/approvals';
    }


    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    function markAsRead(notificationId) {
        app_url = `{{ url('/notifications/${notificationId}/mark-as-read') }}`;
        fetch(app_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({})
        })
        .then(response => {

            if (response.status === 200) {
                const notificationCount = document.getElementById('notification-count');
                if (notificationCount) {
                    notificationCount.innerText = Math.max(0, parseInt(notificationCount.innerText) - 1);
                }
            }
        }).catch(error => console.error('Error:', error));
    }

    let app_url = '';

    function archiveNotification(notificationId) {

        app_url = `{{ url('/notifications/${notificationId}/archive') }}`;

        fetch(app_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({})
        })
        .then(response => {

            if (response.status === 200) {
                location.reload();
            }
        }).catch(error => console.error('Error:', error));
    }

    // Ensure modals work in each tab
    function attachClickHandlers() {
        document.querySelectorAll(".notification-item").forEach(item => {
            item.addEventListener("click", function () {
                const id = this.getAttribute("data-id");
                const message = this.getAttribute("data-message");
                const isRead = this.getAttribute("data-is-read") === "true";
                const tab = this.getAttribute("data-tab");
                openNotificationModal(id, message, isRead, tab);
            });
        });
    }

    document.addEventListener("DOMContentLoaded", attachClickHandlers);
</script>
