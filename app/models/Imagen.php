<?php

namespace venta;

class Imagen extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $codigo_imagen;

    /**
     *
     * @var string
     */
    protected $imagenes;

    /**
     * Method to set the value of field codigo_imagen
     *
     * @param integer $codigo_imagen
     * @return $this
     */
    public function setCodigoImagen($codigo_imagen)
    {
        $this->codigo_imagen = $codigo_imagen;

        return $this;
    }

    /**
     * Method to set the value of field imagenes
     *
     * @param string $imagenes
     * @return $this
     */
    public function setImagenes($imagenes)
    {
        $this->imagenes = $imagenes;

        return $this;
    }

    /**
     * Returns the value of field codigo_imagen
     *
     * @return integer
     */
    public function getCodigoImagen()
    {
        return $this->codigo_imagen;
    }

    /**
     * Returns the value of field imagenes
     *
     * @return string
     */
    public function getImagenes()
    {
        return $this->imagenes;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->setSource("imagen");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'imagen';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Imagen[]|Imagen|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Imagen|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
