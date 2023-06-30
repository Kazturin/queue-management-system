// export function showNotification(title, options) {
//     if (!("Notification" in window)) {
//         console.log("This browser does not support desktop notifications.");
//         return;
//     }
//
//     Notification.requestPermission().then(function (permission) {
//         if (permission === "granted") {
//             new Notification(title, options);
//         } else {
//             console.log("Permission denied for desktop notifications.");
//         }
//     });
// }

window.Notifi = Notification;
