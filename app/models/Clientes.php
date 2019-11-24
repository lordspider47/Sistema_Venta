<?php

namespace venta;

class Clientes extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $trabaja;

    /**
     *
     * @var string
     */
    protected $estudia;

    /**
     *
     * @var string
     */
    protected $direccion;

    /**
     *
     * @var string
     */
    protected $nombredepadre;

    /**
     *
     * @var string
     */
    protected $nombredemadre;

    /**
     *
     * @var string
     */
    protected $telefono;

    /**
     *
     * @var string
     */
    protected $activo;

    /**
     *
     * @var integer
     */
    protected $iduser;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field trabaja
     *
     * @param string $trabaja
     * @return $this
     */
    public function setTrabaja($trabaja)
    {
        $this->trabaja = $trabaja;

        return $this;
    }

    /**
     * Method to set the value of field estudia
     *
     * @param string $estudia
     * @return $this
     */
    public function setEstudia($estudia)
    {
        $this->estudia = $estudia;

        return $this;
    }

    /**
     * Method to set the value of field direccion
     *
     * @param string $direccion
     * @return $this
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Method to set the value of field nombredepadre
     *
     * @param string $nombredepadre
     * @return $this
     */
    public function setNombredepadre($nombredepadre)
    {
        $this->nombredepadre = $nombredepadre;

        return $this;
    }

    /**
     * Method to set the value of field nombredemadre
     *
     * @param string $nombredemadre
     * @return $this
     */
    public function setNombredemadre($nombredemadre)
    {
        $this->nombredemadre = $nombredemadre;

        return $this;
    }

    /**
     * Method to set the value of field telefono
     *
     * @param string $telefono
     * @return $this
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Method to set the value of field activo
     *
     * @param string $activo
     * @return $this
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Method to set the value of field iduser
     *
     * @param integer $iduser
     * @return $this
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field trabaja
     *
     * @return string
     */
    public function getTrabaja()
    {
        return $this->trabaja;
    }

    /**
     * Returns the value of field estudia
     *
     * @return string
     */
    public function getEstudia()
    {
        return $this->estudia;
    }

    /**
     * Returns the value of field direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Returns the value of field nombredepadre
     *
     * @return string
     */
    public function getNombredepadre()
    {
        return $this->nombredepadre;
    }

    /**
     * Returns the value of field nombredemadre
     *
     * @return string
     */
    public function getNombredemadre()
    {
        return $this->nombredemadre;
    }

    /**
     * Returns the value of field telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Returns the value of field activo
     *
     * @return string
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Returns the value of field iduser
     *
     * @return integer
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->setSource("clientes");
        $this->belongsTo('iduser', '\Users', 'id', ['alias' => 'Users']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'clientes';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Clientes[]|Clientes|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Clientes|\Phalcon\Mvc\Model\ResultInterface
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
            'id' => 'id',
            'trabaja' => 'trabaja',
            'estudia' => 'estudia',
            'direccion' => 'direccion',
            'nombredepadre' => 'nombredepadre',
            'nombredemadre' => 'nombredemadre',
            'telefono' => 'telefono',
            'activo' => 'activo',
            'iduser' => 'iduser'
        ];
    }

}
