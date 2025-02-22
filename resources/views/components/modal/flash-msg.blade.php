@props(['msg'])

@if (session($msg) || $errors->has($msg))
    <span class="flex items-center justify-center">
        <div id="flash-message-container" class="fixed top-16 z-[60] transform scale-50 opacity-0 animate-popup">
            <p
                class="w-[400px] h-auto py-5 px-5 text-center rounded text-white {{ $msg == 'success' ? 'bg-green-500' : ($msg == 'update' ? 'bg-blue-500' : 'bg-[#F53C11]') }}">
                {{ session($msg) ?? $errors->first($msg) }}
            </p>
        </div>
    </span>
@endif

<script>
    window.onload = function() {
        const flashMessageContainer = document.getElementById('flash-message-container');
        if (flashMessageContainer) {
            setTimeout(() => {
                flashMessageContainer.classList.remove('animate-popup');
                flashMessageContainer.classList.add('animate-popdown');
            }, 2500);
        }
    };
</script>

<style>
    @keyframes popup {
        0% {
            transform: scale(0.5);
            opacity: 0;
        }

        50% {
            transform: scale(1.05);
            opacity: 1;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes popdown {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(0.95);
            opacity: 0.8;
        }

        100% {
            transform: scale(0.5) translateY(20px);
            opacity: 0;
        }
    }

    .animate-popup {
        animation: popup 0.5s ease-out forwards;
    }

    .animate-popdown {
        animation: popdown 0.5s ease-in forwards;
    }
</style>
