import './bootstrap';
import Alpine from 'alpinejs';
import Echo from "laravel-echo";
import { Client as PusherPushNotifications } from '@pusher/push-notifications-web';
import axios from 'axios';

window.Alpine = Alpine;
Alpine.start();

// // Register Service Worker
// if ("serviceWorker" in navigator) {
//     navigator.serviceWorker.register("/service-worker.js")
//         .then(registration => {
//             console.log("Service Worker registered with scope:", registration.scope);
//         })
//         .catch(error => {
//             console.error("Service Worker registration failed:", error);
//         });
// }

// // Request Notification Permission
// document.addEventListener("DOMContentLoaded", function () {
//     if (Notification.permission === "granted") {
//         initializePusherBeams();
//     } else if (Notification.permission !== "denied") {
//         Notification.requestPermission().then(permission => {
//             if (permission === "granted") {
//                 initializePusherBeams();
//             } else {
//                 console.warn("User denied push notification permission.");
//             }
//         });
//     } else {
//         console.warn("Push notifications are blocked. Enable them in browser settings.");
//     }
// });

// // Initialize Pusher Beams
// function initializePusherBeams() {
//     const beamsClient = new PusherPushNotifications({
//         instanceId: 'af05fccf-1db1-431e-a840-f6f2fbee9ff2',
//     });

//     const userId = document.querySelector('meta[name="user-id"]').getAttribute('content');

//     if (!userId) {
//         console.warn("User ID not found, skipping push notification setup.");
//         return;
//     }

//     beamsClient.start()
//         .then(() => beamsClient.setUserId(userId, {
//             headers: {
//                 'Authorization': `Bearer ${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}`
//             }
//         }))
//         .then(() => console.log(`Successfully registered user ${userId} for push notifications!`))
//         .catch(console.error);
// }

window.Pusher = require("pusher-js");

window.Echo = new Echo({
    broadcaster: "pusher",
    key: "3ead942909a597160895",
    cluster: "ap1",
    forceTLS: true,
    authEndpoint: "/pusher/auth",
    authorizer: (channel,option) => {
        return {
            authorize: (socketId, callback) => {
                axios.post('/pusher/auth', {
                    socket_id: socketId,
                    channel_name: channel.name,
                })
                .then(response => {
                    callback(false, response.data);
                })
                .catch(error => {
                    callback(true, error);
                });
            }
        };
    },
    auth: {
        headers: {
            Authorization: 'Bearer ',
            "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]').content
        },
        withCredentials: true // Ensure cookies are sent
    }
});