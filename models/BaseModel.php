<?php

require "./vendor/autoload.php";

class BaseModel
{

    /**
     * @var string Collection name
     */
    protected $collectionName;

    /**
     * @var MongoDB\Client Connection
     */
    protected $client;

    /**
     * @var DataBase MongoDB Database
     */
    protected $db;

    /**
     * @var Collection the collection
     */
    protected $collection;

    /**
     * @var array Valid fields
     */
    protected $fields;

    public function __construct($collectionName)
    {
        $config = array();
        include "config.php";
        $this->client = new MongoDB\Client($config['uri']);
        $this->db = $this->client->selectDatabase($config['db']);
        $this->collectionName = $collectionName;
        $this->collection = $this->db->selectCollection($collectionName);
    }


    /**
     * Insert data
     * @param array $data
     * @return array Data result
     */
    public function create(array $data)
    {
        $now = date("Y-m-d H:i:s");
        $data['criacao'] = $now;
        $data['alteracao'] = $now;
        $data['_id'] = $this->getNextSequence($this->collectionName);
        $result = $this->collection->insertOne($data);
        return array('id' => $result->getInsertedId(), 'insertedCount' => $result->getInsertedCount());
    }

    /**
     * @param int $order (Opcional) ordenação
     * @param array $filters filtros
     */
    public function read($limit = 0, $order = array(), $filters = array())
    {
        $options = array();
        if ($limit != 0)
        {
            $options['limit'] = $limit;
        }
        if ( ! empty($order))
        {
            $options['sort'] = $this->buildOrderings($order);
        }
        $result = $this->collection->find(
                $filters,
                $options
                );
        return iterator_to_array($result);
    }
    /**
     * Formata todas as ordenações para o MongoDB
     * ASC = 1
     * DESC = -1
     */
    protected function buildOrderings($params)
    {
        $result = array_map(function($v){
            $orders = array('asc' => 1, 'desc' => -1);
            return isset($orders[$v]) ? $orders[$v] : 1;
        }, $params);
        return $result;
    }

    /**
     * @param string $id Document ID
     * @param array $data
     */
    public function update($id, array $data)
    {
        $data['alteracao'] = date("Y-m-d H:i:s");
        $result = $this->collection->updateOne(
                array('_id' => (int) $id), 
                array('$set' => $data));
        return array('matchedCount' => $result->getMatchedCount(), 'modifiedCount' => $result->getModifiedCount());
    }

    /**
     * @param string $id document id
     */
    public function delete($id)
    {
        $result = $this->collection->deleteOne(array('_id' => (int) $id));
        return array('deletedCount' => $result->getDeletedCount());
    }

    /**
     * Cria um valor auto-increment para a collection
     * @param string $nameId Nome da collection
     * @return string Valor sequencial gerado
     */
    protected function getNextSequence($nameId)
    {
        $retval = $this->db->_counters->findOneAndUpdate(
                array('_id' => $nameId), 
                array('$inc' => array("seq" => 1)), 
                array("new" => true, "upsert" => true, 'returnDocument'=> MongoDB\Operation\FindOneAndUpdate::RETURN_DOCUMENT_AFTER)
                );
        return $retval['seq'];
    }

}
