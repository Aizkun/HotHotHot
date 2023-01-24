<?php

final class ControleurDocumentation
{

    public function defautAction() : void
    {
        $O_doc = new Documentation();
        Vue::montrer('Documentation/voir', array('readDoc' => $O_doc->readDoc()));
    }

    public function formCreateDocAction() : void
    {
        $O_doc = new Documentation();
        Vue::montrer('Documentation/create', array('formCreate' =>  $O_doc->getCategory()));
    }

    public function createDocAction() : void
    {
        $O_doc = new Documentation();
        Vue::montrer('Documentation/create', array('createDoc' =>  $O_doc->createDoc()));
    }

    public function listDocAction() : void
    {
        $O_doc = new Documentation();
        Vue::montrer('Documentation/listDoc', array('listDoc' =>  $O_doc->getListDoc()));
    }

    public function formUpdateDocAction() : void
    {
        $O_doc = new Documentation();
        Vue::montrer('Documentation/update', array('formUpdate' =>  $O_doc->getUpdate()));
    }

    public function updateDocAction() : void
    {
        $O_doc = new Documentation();
        Vue::montrer('Documentation/update', array('updateDoc' =>  $O_doc->updateDoc()));
    }

    public function deleteDocAction() : void
    {
        $O_doc = new Documentation();
        Vue::montrer('Documentation/admin', array('deleteDoc' =>  $O_doc->deleteDoc()));
    }

    public function formAddCategoryAction() : void
    {
        Vue::montrer('Documentation/formCategory');
    }

    public function addCategoryAction() : void
    {
        $O_doc = new Documentation();
        Vue::montrer('Documentation/formCategory', array('addCategory' =>  $O_doc->addCategory()));
    }
}
