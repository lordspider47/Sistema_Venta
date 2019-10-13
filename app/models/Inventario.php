<?php

class Inventario extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_inventario;

    /**
     *
     * @var integer
     */
    public $cantidad;

    /**
     *
     * @var integer
     */
    public $codigo_articulo;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->setSource("inventario");
        $this->belongsTo('id_inventario', 'Articulo', 'codigo_articulo', ['alias' => 'Articulo']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'inventario';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Inventario[]|Inventario|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Inventario|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
