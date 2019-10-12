<?php

namespace venta;

class Departamento extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $codigo_departamento;

    /**
     *
     * @var string
     */
    protected $nombre_departamento;

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
     * Method to set the value of field nombre_departamento
     *
     * @param string $nombre_departamento
     * @return $this
     */
    public function setNombreDepartamento($nombre_departamento)
    {
        $this->nombre_departamento = $nombre_departamento;

        return $this;
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
     * Returns the value of field nombre_departamento
     *
     * @return string
     */
    public function getNombreDepartamento()
    {
        return $this->nombre_departamento;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->setSource("departamento");
        $this->hasMany('codigo_departamento', '\Categoria', 'codigo_departamento', ['alias' => 'Categoria']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'departamento';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Departamento[]|Departamento|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Departamento|\Phalcon\Mvc\Model\ResultInterface
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
            'codigo_departamento' => 'codigo_departamento',
            'nombre_departamento' => 'nombre_departamento'
        ];
    }

}
