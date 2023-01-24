<?php

foreach ($A_vue['readDoc'][0] as $category) {
    echo '<h2 id="nomCategory">' . $category->nomCategory . '</h2>
            <article>';
    foreach ($A_vue['readDoc'][1] as $title) {
        if ($title->IDCategory != $category->ID){
            continue;
        }
        echo '<h3 id="docTitle">' . $title->title . '</h3>' .
            '<p id="bodyDoc">' . $title->body . '</p>';
    }
    echo '</artiche>';
}