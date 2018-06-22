<?php

/**
 * Controller padrão para um CRUD
 * 
 */

include "./models/BaseModel.php";

abstract class AbstractCRUD
{
    /**
     * @var BaseCRUD objeto base das operações CRUD
     */
    protected $db;
    /**
     * @var array Array associativo com os campos permitidos
     */
    protected $fields;
    
    public function __construct($collection)
    {
        $this->db = new BaseModel($collection);
    }
    
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }
    /**
     * Metodo para Listagem conforme parametros
     * @param array $parameters Parametros da listagem
     * @return array array associativo que contem a listagem
     */
    public function getList($parameters)
    {
        $params = $this->formatParametersList($parameters);
        $list = $this->db->read($params['limit'], $params['order'], $params['filters']);
        return $list;
    }
    /**
     * @param array $parameters Parametros a serem formatados e filtrados
     * @return array array associativo com os parametros necessarios
     */
    protected function formatParametersList($parameters)
    {
        $limit = (isset($parameters['limit']) && is_numeric($parameters['limit'])) ? (int) $parameters['limit'] : 0;
        unset($parameters['limit']);
        $order = (isset($parameters['orderby']) && is_array($parameters['orderby'])) ? $this->filter($parameters['orderby']) : array();
        unset($parameters['orderby']);
        $filters = $this->filter($parameters);
        return array('limit'=>$limit, 'order'=> $order, 'filters'=>$filters);
    }
    /**
     * Operação Create do CRUD
     * @param array $data array associativo com os dados a serem inseridos
     * @return array resultado da operação
     */
    public function postCreate($data)
    {
        $array = json_decode($data, TRUE);
        $filtered = $this->filterFill($this->fields, $array, '');
        return $this->db->create($filtered);
    }
    /**
     * @param int $id ID do documento
     * @param array $data os dados num array associativo 
     * @return array resultado
     */
    public function putUpdate($id, $data)
    {
        $array = json_decode($data, TRUE);
        $filtered = $this->filter($array);
        $result = $this->db->update($id, $filtered);
        return $result;
    }
    /**
     * @param int $id ID do documento que vai ser eliminado
     * @return array Resultado
     */
    public function deleteObject($id)
    {
        $result = $this->db->delete($id);
        return $result;
    }
    /**
     * Filtra permitindo somente os campos que foram especificados
     * @param array $array array asociativo a ser filtrado
     * @return array array filtrado
     */
    protected function filter(array $array)
    {
        $fields = $this->fields;
        $filtered = array_filter($array, function($key) use ($fields){
            return in_array($key, $fields);
        }, ARRAY_FILTER_USE_KEY);
        return $filtered;
    }
    /**
     * Filtra e preenche com um valor default o array de dados
     * @param array $items keys permitidos
     * @param array $array array asociativo que vai ser filtrado
     * @param mixed $default Valor default caso a key não existir no array asociativo
     * @return array array filtrado
     */
    protected function filterFill($items, array $array, $default = NULL)
    {
        $return = array();
        is_array($items) OR $items = array($items);
        foreach ($items as $item)
        {
            $return[$item] = array_key_exists($item, $array) ? $array[$item] : $default;
        }
        return $return;
    }
    
}
