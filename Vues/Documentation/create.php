<?php

if(!isset($_SESSION)){
session_start();
}

if(isset($_SESSION['log']) && $_SESSION['log'] == 'A') {

echo '
    <form class="form-text" action="/Documentation/createDoc" method="POST">
        <label class="form-label" for="title">Titre :</label>
        <input type="text" name="title" id="title" placeholder="magnifique titre de documentation"
               class="input-group-text" required>
        <label class="form-label" for="body">Contenu :</label>
        <textarea name="body" id="body" class="input-group-text" required></textarea>
        <label class="form-label" for="category">Contenu :</label>
        <select name="category" id="category" required>';
       foreach ($A_vue['formCreate'] as $category){
          echo '<option value="'. $category->ID .'">'. $category->nomCategory .'</option>';
       }
    echo '</select>
        <input type="submit" name="submit" value="Enregistrer" class="btn btn-lg btn-primary btn-block">
    </form>';
    if (isset($A_vue['createDoc'])) {
        echo '<p id="resultRequest">' . $A_vue['createDoc'] . '</p>';
    }
}
else {
    header('Location: /Documentation');
}
?>

