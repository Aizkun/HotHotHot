<?php


if(!isset($_SESSION)){
session_start();
}

if(isset($_SESSION['log']) && $_SESSION['log'] == 'A' && !isset($_SESSION['otherLogin'])) {

echo '
<h2 class="text-center">Que voulais vous faire ?</h2>
<div class="d-grid gap-2 col-6 mx-auto">
    <a class="btn btn-primary" href="../Documentation/formCreateDoc" role="button">Créer une documentation</a>
    <a class="btn btn-primary" href="../Documentation/listDoc" role="button">Pannel documentation</a>
    <a class="btn btn-primary" href="../Documentation/" role="button">Voir la documentaiton</a>
    <a class="btn btn-primary" href="../Documentation/formAddCategory" role="button">Ajouter une catégorie</a>
</div>';

}
else {
    header('Location: /Documentation');
}
?>

