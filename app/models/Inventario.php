<?php

namespace venta;

class Inventario extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $codigo_articulo;

    /**
     *
     * @var integer
     */
    protected $id_inventario;

    /**
     *
     * @var integer
     */
    protected $cantidad;

    /**
     * Method to set the value of field codigo_articulo
     *
     * @param integer $codigo_articulo
     * @return $this
     */
    public function setCodigoArticulo($codigo_articulo)
    {
        $this->codigo_articulo = $codigo_articulo;

        return $this;
    }

    /**
     * Method to set the value of field id_inventario
     *
     * @param integer $id_inventario
     * @return $this
     */
    public function setIdInventario($id_inventario)
    {
        $this->id_inventario = $id_inventario;

        return $this;
    }

    /**
     * Method to set the value of field cantidad
     *
     * @param integer $cantidad
     * @return $this
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Returns the value of field codigo_articulo
     *
     * @return integer
     */
    public function getCodigoArticulo()
    {
        return $this->codigo_articulo;
    }

    /**
     * Returns the value of field id_inventario
     *
     * @return integer
     */
    public function getIdInventario()
    {
        return $this->id_inventario;
    }

    /**
     * Returns the value of field cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->setSource("inventario");
        $this->belongsTo('codigo_articulo', '\Articulo', 'codigo_articulo', ['alias' => 'Articulo']);
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

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return [
            'codigo_articulo' => 'codigo_articulo',
            'id_inventario' => 'id_inventario',
            'cantidad' => 'cantidad'
        ];
    }

}
