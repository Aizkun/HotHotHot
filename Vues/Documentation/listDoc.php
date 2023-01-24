<?php

if(!isset($_SESSION)){
    session_start();
}

if(isset($_SESSION['log']) && $_SESSION['log'] == 'A') {

    foreach ($A_vue['listDoc'][0] as $documentation) {
        echo '
        <article class="doclist">
            <h2>'. $documentation->title .'</h2>
        <form id="reload" action="../Documentation/formUpdateDoc" method="POST">
			<input class="btn btn-primary" id="mark" type="submit" name="update" value="modifier documentation">
	   		<input type="hidden" name="id" value="' . $documentation->ID . '">
	   		<br>
	   	    <button id="suppr' . $documentation->ID . '" type="button" class="btn btn-danger" onclick="Delete(\'' . $documentation->ID . '\')">supprimer documentation</button>
	    </form>
        </article>
        <main hidden id="'. $documentation->ID .'" class="modal2">
            <article class="modal-content" id="modal-content">
                <i class="close" onclick="document.getElementById(\'' . $documentation->ID . '\').setAttribute(\'hidden\', true);">+</i>
                <h2 id="titre-popup">Supprimer Documentation</h2>
                <article id="modal-body" class="modal-body">
                    <h3 id="titre-capteur">Etes vous sûre de supprimer cette documentation ?</h3>
                    <form id="croix" action="../Documentation/deleteDoc" method="POST">
                            <button type="button" class="btn btn-success" onclick="document.getElementById(\'' . $documentation->ID . '\').setAttribute(\'hidden\', true);" class="cancelbtn">Annuler</button>
                            <input type="hidden" name="id" value="' . $documentation->ID . '">
                            <input class="btn btn-primary" id="btnDelete" type="submit" name="delete" value="Supprimer">
                    </form>   
                </article> 	
            </article>
        </main>';
    }
}
else {
    header('Location: /Documentation');
}
?>

