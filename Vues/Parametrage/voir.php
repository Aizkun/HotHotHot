<?php
if(!isset($_SESSION)){
    session_start();
}
if(!isset($_SESSION['log']) && !$_SESSION['log'] == 'U') {
    header('Location: /Pages/home');
}
?>
<p>La page de parametrage</p>
