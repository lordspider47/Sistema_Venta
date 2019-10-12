<?php

namespace venta;

class Articulo extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $codigo_categoria;

    /**
     *
     * @var integer
     */
    protected $codigo_articulo;

    /**
     *
     * @var string
     */
    protected $titulo;

    /**
     *
     * @var string
     */
    protected $precio;

    /**
     *
     * @var string
     */
    protected $descripcion;

    /**
     *
     * @var string
     */
    protected $descuento;

    /**
     *
     * @var string
     */
    protected $envio;

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
     * Method to set the value of field titulo
     *
     * @param string $titulo
     * @return $this
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Method to set the value of field precio
     *
     * @param string $precio
     * @return $this
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Method to set the value of field descripcion
     *
     * @param string $descripcion
     * @return $this
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Method to set the value of field descuento
     *
     * @param string $descuento
     * @return $this
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;

        return $this;
    }

    /**
     * Method to set the value of field envio
     *
     * @param string $envio
     * @return $this
     */
    public function setEnvio($envio)
    {
        $this->envio = $envio;

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
     * Returns the value of field codigo_articulo
     *
     * @return integer
     */
    public function getCodigoArticulo()
    {
        return $this->codigo_articulo;
    }

    /**
     * Returns the value of field titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Returns the value of field precio
     *
     * @return string
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Returns the value of field descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Returns the value of field descuento
     *
     * @return string
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * Returns the value of field envio
     *
     * @return string
     */
    public function getEnvio()
    {
        return $this->envio;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->setSource("articulo");
        $this->hasMany('codigo_articulo', '\Inventario', 'codigo_articulo', ['alias' => 'Inventario']);
        $this->belongsTo('codigo_categoria', '\Categoria', 'codigo_categoria', ['alias' => 'Categoria']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'articulo';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Articulo[]|Articulo|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Articulo|\Phalcon\Mvc\Model\ResultInterface
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
            'codigo_articulo' => 'codigo_articulo',
            'titulo' => 'titulo',
            'precio' => 'precio',
            'descripcion' => 'descripcion',
            'descuento' => 'descuento',
            'envio' => 'envio'
        ];
    }

}
