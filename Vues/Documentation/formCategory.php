<?php

if(!isset($_SESSION)){
    session_start();
}

if(isset($_SESSION['log']) && $_SESSION['log'] == 'A') {

    echo '
        <form class="form-text" action="/Documentation/addCategory" method="POST">
            <label class="form-label" for="category">Category :</label>
            <input type="text" name="category" id="category" size="50"  placeholder="Test" class="input-group-text" required>
            <input type="submit" name="submit" value="Envoyer" class="btn btn-lg btn-primary btn-block">
        </form>
        ';
    if (isset($A_vue['addCategory'])) {
        echo '<p id="resultRequest">' . $A_vue['addCategory'] . '</p>';
    }
}
else {
    header('Location: /Documentation');
}
?>

