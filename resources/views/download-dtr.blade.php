<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Downloading...</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-white text-black">

    <!-- Loading Screen -->
    <div class="flex flex-col items-center text-center space-y-6">
        <!-- Loading GIF -->
        <img src="{{asset('resources/animated/loading.gif')}}" alt="Loading..." class="w-full h-auto">

        <!-- Downloading Text -->
        <h1 class="text-2xl font-semibold animate-pulse">Downloading... Please Wait</h1>
        
        <!-- Timeout Message -->
        <p class="text-gray-400 text-sm font-semibold">This window will redirect in <span id="timer">10</span> seconds.</p>

        <!-- Go Back Button (Hidden initially) -->
        <button id="go-back-btn" class="hidden bg-orange-500 text-white font-semibold px-6 py-2 mt-4 rounded-lg" onclick="window.location.href = `{{route('users.request')}}`">Go Back</button>
    </div>

    <!-- Auto Close Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let seconds = 10;
            const timerElement = document.getElementById("timer");
            const goBackBtn = document.getElementById("go-back-btn");

            // Countdown Timer
            const countdown = setInterval(() => {
                seconds--;
                timerElement.textContent = seconds;
                if (seconds <= 0) {
                    clearInterval(countdown);
                    goBackBtn.classList.remove("hidden"); // Show "Go Back" button
                }
            }, 1000);

            // Auto-submit form
            document.getElementById("downloadForm").submit();
        });
    </script>

    <!-- Hidden Form -->
    <form id="downloadForm" action="{{ route('download.pdf') }}" method="POST">
        @csrf
        <input type="hidden" name="user" value="{{ json_encode($user, true) }}">
        <input type="hidden" name="yearlyTotals" value="{{ json_encode($yearlyTotals, true) }}">
        <input type="hidden" name="records" value="{{ json_encode($records, true) }}">
        <input type="hidden" name="totalHoursPerMonth" value="{{ json_encode($totalHoursPerMonth, true) }}">
        <input type="hidden" name="selectedMonth" value="{{ $selectedMonth }}">
        <input type="hidden" name="selectedYear" value="{{ $selectedYear }}">
        <input type="hidden" name="pagination" value="{{ json_encode($pagination, true) }}">
        <input type="hidden" name="type" value="{{ json_encode($type) }}">
        <input type="hidden" name="approved_by" value="{{$approved_by}}">
    </form>

</body>
</html>
