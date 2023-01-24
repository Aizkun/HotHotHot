<?php
if(!isset($_SESSION)){
    session_start();
}
if(!isset($_SESSION['log']) && !$_SESSION['log'] == 'U') {
    header('Location: /Pages/login');
} 
?>
<main hidden id="capteur">
    <article>
        <h2>Capteur intérieur</h2>
        <img src="../img/temp.jpg" alt="Compteur permettant de montrer la température intérieur de chez vous">
        <p id="capteurData1"></p>
    </article>
    <article>
        <h2>Capteur extérieur</h2>
        <img src="../img/temp.jpg" alt="Compteur permettant de montrer la température extérieur de chez vous">
        <p id="capteurData2"></p>
    </article>
</main>
<main id="modal" class="modal">
    <article class="modal-content" id="modal-content">
<!--        <i class="close">&times;</i>-->
        <div class="close">+</div>
        <h2 id="titre-popup">Notification</h2>
        <article id="modal-body" class="modal-body">
            <h3 id="titre-capteur">État des températures</h3>
        </article>
    </article>
</main>
<?php
echo '
<script type="module" src="' . Constantes::repertoireJS() . 'Temperatures/popup.js"></script>
<script src="' . Constantes::repertoireJS() . 'Temperatures/Ajax_temp.js"></script>';
