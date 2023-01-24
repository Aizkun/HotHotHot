<?php

require 'db.php';

final class Temperature
{
    public function jsonTemp()
    {
        $obj = new stdClass();


        $positionFile = "../temperature.json";
        $fileContent = file_get_contents($positionFile);

        $mots = json_encode($obj);

        $fileRewrite = fopen($positionFile,"w+");
        fputs($fileRewrite, $fileContent);
        fclose($fileRewrite);

    }
    public function paginationTemperature() : array
    {
        session_start();
        $db = new DB();

        $url = $_GET['url'];
        $urlExplode = explode('/', $url);
        $currentPage = (int)ucfirst($urlExplode[2]);
        $parPage = 20;
        $element = 0;
        $premier = ($currentPage * $parPage) - $parPage;
        $temperature = $db->queryDB("SELECT * From Temperature ORDER BY ID LIMIT $premier, $parPage");

        $nbTemperatureTotal = $db->queryDB("SELECT COUNT(*) AS nb_temp FROM Temperature");
        $result2 = $nbTemperatureTotal->fetch();
        $nbTemperature = (int)$result2->nb_temp;
        $pages = ceil($nbTemperature / $parPage);

        while ($resultTemperature = $temperature->fetch()) {

        }
        if ($currentPage == 1) {
           $precedent = '';
        }else{
            $precedent = ($currentPage -= 1);
        }
        $tableauPage = [];
        for ($page = 1; $page <= $pages; $page++) {
            $tableauPage[] = $page;
        }
        if ($currentPage == 1) {
           $tableauPage = [1];
        }
        if ($currentPage == $pages || $currentPage == end($tableauPage)){
            $suivant = '';
        } else{
            $suivant = ($currentPage += 1);
        }
        return [$precedent,$tableauPage,$suivant];
    }

    public function deleteTemperature()
    {
        session_start();
        $db = new DB();

        $requestNbTemp = $db->queryDB("SELECT COUNT(*) AS nb_temp FROM Temperature");
        $resultNbTemp = $requestNbTemp->fetch();
        $nbTemperatureTotal = $resultNbTemp->nb_temp;

        $db->queryDB("DELETE FROM Temperature");
    }

}
