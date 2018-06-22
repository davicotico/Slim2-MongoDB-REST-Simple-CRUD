<?php

require "AbstractCRUD.php";

class Cidades extends AbstractCRUD
{

    public function __construct()
    {
        parent::__construct('cidade');
        $fields = array('nome', 'estadoId', 'criacao', 'alteracao');
        $this->setFields($fields);
    }

}
