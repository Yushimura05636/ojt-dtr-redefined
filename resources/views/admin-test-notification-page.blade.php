
<html lang="en">
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

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Axios CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


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

    <h1>Push Notifications</h1>
    
    <button id="subscribe">Subscribe</button>
    <button id="sendNotification">Send Notification</button>

    <script>
        //Pusher.logToConsole = true; // Debugging, remove in production
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

   </script>
   <script>
    
    //Pusher.logToConsole = true; // Debugging, remove in production

    var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        forceTLS: true
    });

    var user_id = "{{ auth()->id() }}"; // Get logged-in user's ID

    var channel = pusher.subscribe("public-notifications");

    // ✅ Listen only to events specific to this user
    channel.bind(`user-notification-${user_id}`, function (data) {
        let audio = new Audio('/resources/sfx/notification_sound_sfx.ogg');
        audio.play();
        alert(1);
    });

    alert(user_id)
</script>

    
</body>
</head>
</html>