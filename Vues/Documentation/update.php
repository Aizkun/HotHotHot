<?php

if(!isset($_SESSION)){
session_start();
}

if(isset($_SESSION['log']) && $_SESSION['log'] == 'A') {

    if(isset($A_vue['formUpdate'])){
        foreach ($A_vue['formUpdate'][0] as $documentation) {
            echo '
        <form class="form-text" action="/Documentation/updateDoc" method="POST">
            <label class="form-label" for="title">Titre :</label>
            <input type="text" name="title" id="title" placeholder="magnifique titre de documentation"
                   class="input-group-text" value="' . $documentation->title . '" required>
            <label class="form-label" for="body">Contenu :</label>
            <textarea name="body" id="body" class="input-group-text" required>' . $documentation->body . '</textarea>
            <label class="form-label" for="category">Contenu :</label>
            <select name="category" id="category">';
            foreach ($A_vue['formUpdate'][1] as $category) {
                if ($documentation->IDCategory == $category->ID) {
                    echo '<option value="' . $category->IDCategory . '" selected>' . $category->nomCategory . '</option>';
                }
                echo '<option value="' . $category->ID . '">' . $category->nomCategory . '</option>';
            }
            echo '</select>
            <input type="hidden" name="id" value="' . $documentation->ID . '">
            <input type="submit" name="submit" value="Modifier" class="btn btn-lg btn-primary btn-block">
        </form>';
        }
    }
}
else {
    header('Location: /Documentation');
}
?>

