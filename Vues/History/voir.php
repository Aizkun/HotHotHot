<?php
if(!isset($_SESSION)){
    session_start();
}
if(!isset($_SESSION['log']) && !$_SESSION['log'] == 'U') {
    header('Location: /Pages/home');
}
echo'
<canvas id="myChart" style="width: 80%; height: 250px;margin-left: auto;margin-right: auto;"></canvas>
<canvas id="myChart2" style="width: 80%; height: 250px;margin-left: auto;margin-right: auto;"></canvas>
<main id="historique">
</main>
<nav aria-label="Page navigation example">
  <ul class="pagination">';

echo'
    <li class="page-item"><a class="page-link" href="' . $A_vue['pagination'][0] . '">Previous</a></li>';
foreach ($A_vue['pagination'][1] as $page){
    echo'
    <li class="page-item"><a class="page-link" href="' . $page .'">1</a></li>';
}
    echo'
    <li class="page-item"><a class="page-link" href="' . $A_vue['pagination'][2] . '">Next</a></li> 
  </ul>
 </nav> 
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="' . Constantes::repertoireJS() . 'Temperatures/graphe.js"></script>
<script type="module" src="' . Constantes::repertoireJS() . 'Temperatures/historique.js"></script>';
