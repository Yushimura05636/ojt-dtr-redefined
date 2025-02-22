<!Doctype html lang="en">
<head>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusher Beams Notification</title>

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
</head>
<body>
    <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
        <h2 class="text-lg font-semibold mb-4">Notification Index Data</h2>

        @if($notificationIndex->isNotEmpty())
            <ul class="bg-gray-100 p-2 rounded text-gray-700">
                @foreach($notificationIndex as $index)
                    <li class="p-1 border-b">Index: {{ $index->id }} - {{ $index->message }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No index available</p>
        @endif
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
        <h2 class="text-lg font-semibold mb-4">DTR Request Index Data</h2>
    
        @if($dtrRequestIndex->isNotEmpty())
            <ul class="bg-gray-100 p-2 rounded text-gray-700">
                @foreach($dtrRequestIndex as $index)
                    <li class="p-1 border-b">
                        Index: {{ $index->id }} - {{ $index->month }} - {{ $index->year }}
    
                        <!-- Accept & Decline Buttons -->
<button type="button" name="accept-dtr" data-to-user-id="{{ $index->user_id }}" data-month="{{ $index->month }}" data-year="{{ $index->year }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
    Accept
</button>

<button type="button" name="decline-dtr" data-to-user-id="{{ $index->user_id }}" data-month="{{ $index->month }}" data-year="{{ $index->year }}" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
    Decline
</button>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No index available</p>
        @endif
    </div>

    <h1>Push Notifications</h1>
    
    <button id="subscribe">Subscribe</button>
    <button id="sendNotification">Send Notification</button>

    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        const user_id = `{!! auth()->id() !!}`;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content"); // ✅ Fixed the issue

        console.log("CSRF Token:", csrfToken);

        var pusher = new Pusher(`{{env('PUSHER_APP_KEY')}}`, {
            cluster: `{{ env('PUSHER_APP_CLUSTER') }}`,
        });

        var channel = pusher.subscribe('public-notifications');
        channel.bind('my-event', function(data) {
            toastr.success(data);
        });

        document.getElementById('sendNotification').addEventListener('click', function () {
            fetch("{{ route('send.notification') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // ✅ Fixed the CSRF token issue
                },
                body: JSON.stringify({
                    month: 2,
                    year: 2025,
                    to_user_id: 1,
                })
            })
            .then(response => response.json())
            .then(data => console.log('Notification sent:', data))
            .catch(error => console.error('Error:', error));
        });

        alert(user_id);

        
        document.addEventListener("DOMContentLoaded", function () {
        function handleDtrRequest(action, toUserId, month, year) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            const url = action === 'accept' ? "/admin-dtr-approve" : "admin-dtr-decline"; // Change to your actual endpoints

            fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({
                    to_user_id: toUserId,
                    from_user_id: 1,
                    month: month,
                    year: year,
                }),
            })
            .then(response => {
                if (response.status === 200) {
                    toastr.success(`DTR request ${action}ed successfully.`);
                } else {
                    toastr.error(`Failed to ${action} DTR request.`);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                toastr.error("Something went wrong. Try again.");
            });
        }

        // Accept Button
        document.querySelectorAll('[name="accept-dtr"]').forEach(button => {
            button.addEventListener("click", function () {
                const toUserId = this.dataset.toUserId;
                const month = this.dataset.month;
                const year = this.dataset.year;
                handleDtrRequest("accept", toUserId, month, year);
            });
        });

        // Decline Button
        document.querySelectorAll('[name="decline-dtr"]').forEach(button => {
            button.addEventListener("click", function () {
                const toUserId = this.dataset.toUserId;
                const month = this.dataset.month;
                const year = this.dataset.year;
                handleDtrRequest("decline", toUserId, month, year);
            });
        });
    });

    </script>
</body>
</html>
