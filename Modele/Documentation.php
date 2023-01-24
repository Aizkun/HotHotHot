<?php
require('db.php');

final class Documentation
{
    private function addDoc($title, $body, $idCategory)
    {
        $db = new DB();
        return $db->execDB("INSERT INTO documentation (title,body,IDCategory) 
                               VALUES ('$title','$body','$idCategory')");
    }
    public function createDoc() : string
    {
        $title = htmlspecialchars($_POST['title'], ENT_QUOTES);
        $body = htmlspecialchars($_POST['body'], ENT_QUOTES);
        $idCategory = $_POST['category'];
        $titleClean = strip_tags($title);
        $bodyClean = strip_tags($body);
        $this->addDoc($titleClean,$bodyClean,$idCategory);
        return "Documentation crée";
    }

    private function removeDoc($id)
    {
        $db = new DB();
        return $db->execDB("DELETE FROM documentation WHERE ID='$id'");
    }

    public function deleteDoc() : void
    {
        $id = $_POST['id'];
        $this->removeDoc($id);
    }

    public function readDoc() : array
    {
        $db = new DB();
        $requestDocumentation = $db->queryDB("SELECT * FROM documentation ORDER BY IDCategory ASC");
        $requestCategory = $db->queryDB('SELECT * FROM category');
        $resultDocumentation = $requestDocumentation->fetchAll();
        $resultCategory = $requestCategory->fetchAll();

        return [$resultCategory,$resultDocumentation];
    }

    public function updateDoc() : string
    {
        $db = new DB();
        $id = $_POST['id'];
        $title = htmlspecialchars($_POST['title'], ENT_QUOTES);
        $body = htmlspecialchars($_POST['body'], ENT_QUOTES);
        $idCategory = $_POST['category'];
        $db->execDB("UPDATE documentation SET title ='$title', body ='$body', IDCategory ='$idCategory' WHERE ID ='$id'");
        header('Location: /Documentation/');
        return "Modification faite";
    }

    public function addCategory() : string
    {
        $db = new DB();
        $category = htmlspecialchars($_POST['category'], ENT_QUOTES);
        $request = $db->queryDB("SELECT * FROM category WHERE nomCategory LIKE '%$category%'");

        $resultRequest = $request->fetchAll();
        if($resultRequest){
            return "Catégorie portant ce nom à déja été ajouter";
        }
        $db->execDB("INSERT INTO category (nomCategory) 
                               VALUES ('$category')");
        return "Categorie ajoutée";
    }

    public function getCategory() : array
    {
        $db = new DB();
        $request = $db->queryDB("SELECT * FROM category");
        $resultRequest = $request->fetchAll();
        return $resultRequest;
    }

    public function getListDoc() : array
    {
        $db = new DB();
        $request = $db->queryDB("SELECT * FROM documentation");
        $resultRequest = $request->fetchAll();
        return [$resultRequest];
    }

    public function getUpdate() : array
    {
        $db = new DB();
        $id = $_POST['id'];
        $request = $db->queryDB("SELECT * FROM documentation WHERE ID='$id'");
        $resultRequest = $request->fetchAll();
        $resultCategory = $this->getCategory();
        return [$resultRequest,$resultCategory];
    }
}
?>