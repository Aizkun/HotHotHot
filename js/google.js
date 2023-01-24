function onSignIn(googleUser) {
    let profile = googleUser.getBasicProfile();

    let xhr = new XMLHttpRequest();
    xhr.open('POST', '../../Users/otherLogin');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        console.log('Signed in as: ' + profile.getEmail());
    };
    xhr.send('email=' + profile.getEmail() + '&nom=' + profile.getFamilyName() + '&prenom=' + profile.getGivenName());
}
function redirect(){
    setInterval(function(){ location.reload(); }, 5000);
}

function signOut() {
    let xhr = new XMLHttpRequest();

    xhr.open('POST', '../../Pages/logout');

    let auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        console.log('User signed out.');
    });
    xhr.send(null);
    location.replace("../Pages");
}
