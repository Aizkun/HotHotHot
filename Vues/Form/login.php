<?php
if(!isset($_SESSION)){
    session_start();
}
if(isset($_SESSION['log']) && $_SESSION['log'] == 'U') {
    header('Location: /Pages/home');
}
else {

    echo '
      <script src="' . Constantes::repertoireJS() . 'facebook.js"></script>

    <form class="form-text" action="/Users/login" method="POST">
    <div class="fb-login-button" data-width="" data-size="medium" data-button-type="continue_with" data-layout="default" data-auto-logout-link="true" data-use-continue-as="false"></div>
        <hr>
        <label class="form-label" for="email">Email :</label>
        <input type="email" name="email" id="email" size="50" pattern="[a-zA-Z0-9.!#$%&*+/=?^_`{|}~-]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" placeholder="toto@exemple.com"
               class="input-group-text" required>
        <label class="form-label" for="mdp">Mot de passe :</label>
        <input type="password" name="mdp" id="mdp" class="input-group-text">
        <a href="../Pages/register">Vous n\'êtes pas inscrit ?</a>
        <a href="../Pages/recuperationMail" class="link-info">Mot de passe oublié ?</a>
        <input type="submit" name="submit" value="Envoyer" class="btn btn-lg btn-primary btn-block">
    </form>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v12.0&appId=1106961673409948&autoLogAppEvents=1" nonce="nQGmiQse"></script>';
}
?>