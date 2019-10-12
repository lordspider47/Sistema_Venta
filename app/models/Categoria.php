<?php

namespace venta;

class Categoria extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $codigo_categoria;

    /**
     *
     * @var string
     */
    protected $nombre_categoria;

    /**
     *
     * @var integer
     */
    protected $codigo_departamento;

    /**
     * Method to set the value of field codigo_categoria
     *
     * @param integer $codigo_categoria
     * @return $this
     */
    public function setCodigoCategoria($codigo_categoria)
    {
        $this->codigo_categoria = $codigo_categoria;

        return $this;
    }

    /**
     * Method to set the value of field nombre_categoria
     *
     * @param string $nombre_categoria
     * @return $this
     */
    public function setNombreCategoria($nombre_categoria)
    {
        $this->nombre_categoria = $nombre_categoria;

        return $this;
    }

    /**
     * Method to set the value of field codigo_departamento
     *
     * @param integer $codigo_departamento
     * @return $this
     */
    public function setCodigoDepartamento($codigo_departamento)
    {
        $this->codigo_departamento = $codigo_departamento;

        return $this;
    }

    /**
     * Returns the value of field codigo_categoria
     *
     * @return integer
     */
    public function getCodigoCategoria()
    {
        return $this->codigo_categoria;
    }

    /**
     * Returns the value of field nombre_categoria
     *
     * @return string
     */
    public function getNombreCategoria()
    {
        return $this->nombre_categoria;
    }

    /**
     * Returns the value of field codigo_departamento
     *
     * @return integer
     */
    public function getCodigoDepartamento()
    {
        return $this->codigo_departamento;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->setSource("categoria");
        $this->hasMany('codigo_categoria', '\Articulo', 'codigo_categoria', ['alias' => 'Articulo']);
        $this->belongsTo('codigo_departamento', '\Departamento', 'codigo_departamento', ['alias' => 'Departamento']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'categoria';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Categoria[]|Categoria|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Categoria|\Phalcon\Mvc\Model\ResultInterface
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
            'codigo_categoria' => 'codigo_categoria',
            'nombre_categoria' => 'nombre_categoria',
            'codigo_departamento' => 'codigo_departamento'
        ];
    }

}
