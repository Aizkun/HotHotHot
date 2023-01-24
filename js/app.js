/*Enregistrement service worker*/
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js', { scope: '/' }).then(function (reg) {

        if (reg.installing) {
            console.log('Service worker installing');
        } else if (reg.waiting) {
            console.log('Service worker installed');
        } else if (reg.active) {
            console.log('Service worker active');
        }

    }).catch(function (error) {
        // registration failed
        console.log('Registration failed with ' + error);
    });
}




/*Home screen button*/
let deferredPrompt;
const addBtn = document.querySelector('.add-button');
const postBtn = document.getElementById("post-button");
addBtn.style.display = 'none';
postBtn.style.display = 'block';

window.addEventListener('beforeinstallprompt', (e) => {
    // Prevent Chrome 67 and earlier from automatically showing the prompt
    e.preventDefault();
    // Stash the event so it can be triggered later.
    deferredPrompt = e;
    // Update UI to notify the user they can add to home screen
    addBtn.style.display = 'block';
    addBtn.style.display = 'none';
    addBtn.addEventListener('click', (e) => {
        // hide our user interface that shows our A2HS button
        addBtn.style.display = 'none';
        // Show the prompt
        deferredPrompt.prompt();
        // Wait for the user to respond to the prompt
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('User accepted the A2HS prompt');
            } else {
                console.log('User dismissed the A2HS prompt');
            }
            deferredPrompt = null;
        });
    });
});







/*Notifications simples*/

var button = document.getElementById("notifications");
button.addEventListener('click', function(e) {
    Notification.requestPermission().then(function(result) {
        if(result === 'granted') {
            randomNotification();
        }
    });
});

function randomNotification() {
    var randomNumber = getRandomInt(5);
    console.log(randomNumber);
    if(randomNumber >= 2) {

            var notifTitle = "Chaud, non ?";
            var notifBody = 'Température : ' + randomNumber + '.';
            var notifImg = '/assets/images/android-chrome-192x192.png';
            var options = {
                body: notifBody,
                icon: notifImg
            }
            var notif = new Notification(notifTitle, options);

    }
    setTimeout(randomNotification, 30000);
}

    //On génére un nombre aléatoire pour la démo
    function getRandomInt(max) {
        return Math.floor(Math.random() * Math.floor(max));
    }




