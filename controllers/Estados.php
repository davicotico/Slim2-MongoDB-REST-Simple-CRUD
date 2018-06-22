<?php

require "AbstractCRUD.php";

class Estados extends AbstractCRUD
{

    public function __construct()
    {
        parent::__construct('estado');
        $fields = array('nome', 'abreviacao', 'criacao', 'alteracao');
        $this->setFields($fields);
    }

}
