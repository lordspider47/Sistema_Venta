<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use venta\Articulo;
use venta\Inventario;

class ArticuloController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for articulo
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, '\venta\Articulo', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "codigo_categoria";

        $articulo = Articulo::find($parameters);
        if (count($articulo) == 11100000) {
            $this->flash->notice("NO SE HA ENCONTRADO EL ARTICULO BUSCADO");

            $this->dispatcher->forward([
                "controller" => "articulo",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $articulo,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a articulo
     *
     * @param string $codigo_categoria
     */
    public function editAction($codigo_categoria)
    {
        if (!$this->request->isPost()) {

            $articulo = Articulo::findFirstBycodigo_categoria($codigo_categoria);
            if (!$articulo) {
                $this->flash->error("EL ARTICULO NO HA SIDO ENCONTRADO");

                $this->dispatcher->forward([
                    'controller' => "articulo",
                    'action' => 'index'
                ]);

                return;
            }
            $this->view->codigo_categoria = $articulo->getCodigoCategoria();

            $this->tag->setDefault("codigo_categoria", $articulo->getCodigoCategoria());
            $this->tag->setDefault("codigo_articulo", $articulo->getCodigoArticulo());
            $this->tag->setDefault("titulo", $articulo->getTitulo());
            $this->tag->setDefault("precio", $articulo->getPrecio());
            $this->tag->setDefault("descripcion", $articulo->getDescripcion());
            $this->tag->setDefault("descuento", $articulo->getDescuento());
            $this->tag->setDefault("envio", $articulo->getEnvio());
            $this->tag->setDefault("ruta", $articulo->getRuta());






            $id_imagen = $this->request->getPost("codigo_articulo");

            /*$articulo = Articulo::findFirstBycodigo_categoria($codigo_categoria);

            $id_imagen = $articulo->codigo_articulo;*/

            if($_FILES["ruta"]["error"]>0){
            echo "Error al cargar archivo";
            } else {

            $permitidos = array("image/gif","image/png","image/jpg");
            $limite_kb = 2000;

            if (in_array($_FILES["ruta"]["type"], $permitidos) && $_FILES["ruta"]["size"] <= $limite_kb * 1024){

                $ruta = 'files/'.$id_imagen.'/';
                $archivo = $ruta.$_FILES["ruta"]["name"];
                $articulo->setRuta($_FILES["ruta"]["name"]);
                if (!file_exists($ruta)){
                    mkdir($ruta);
                }

                if (!file_exists($archivo)) {
                    $resultado = @move_uploaded_file($_FILES["ruta"]["tmp_name"], $archivo);

                    if ($resultado) {
                        echo "Archivo Guardado";
                        }else{
                        echo "Error al guardar archivo";
                    }

                    }else{
                        echo "Archivo ya existe";
                        }

                } else {
                echo "Archivo no permitido o tamaño excedido";
            }
        }

        

            


            /**$id_imagen = $this->tag->setDefault("codigo_articulo", $articulo->getCodigoArticulo());*/
            
        }
    }


    /**
     * Edits a articulo
     *
     * @param string $codigo_categoria
     */
    public function eliminarAction($codigo_categoria)
    {
        if (!$this->request->isPost()) {

            $articulo = Articulo::findFirstBycodigo_categoria($codigo_categoria);
            $codigo = $articulo->codigo_articulo;
            $inventario = Inventario::findFirstBycodigo_articulo($codigo);
            if ($inventario->codigo_articulo == $articulo->codigo_articulo) {

                $this->flash->error("NO SE PUEDE ELIMINAR EL ARTICULO PORQUE TIENE UN INVENTARIO ASIGNADO A ESTE");
                $this->dispatcher->forward([
                    "controller" => "articulo",
                    "action" => "search"

                ]);
                return;

            }



            /*if (!$articulo) {
                $this->flash->error("EL ARTICULO NO HA SIDO ENCONTRADO");

                $this->dispatcher->forward([
                    'controller' => "articulo",
                    'action' => 'index'
                ]);

                return;
            }*/
            
            /*$taru = $articulo->ruta;
            $borar = $articulo->codigo_articulo;
            

                unlink('/'.$taru);
                rmdir('files/'.$borar);***********/


                /**foreach (glob('files/'.'/*' as $borar) {*/
                /**if(is_dir($borar)){
                    rmdir($borar);
                } else{
                    unlink($borar);
                }*/
            /*}*/
            
            /*rmdir('files/'.$borar.'/');*/

            $this->view->codigo_categoria = $articulo->getCodigoCategoria();

            $this->tag->setDefault("codigo_categoria", $articulo->getCodigoCategoria());
            $this->tag->setDefault("codigo_articulo", $articulo->getCodigoArticulo());
            $this->tag->setDefault("titulo", $articulo->getTitulo());
            $this->tag->setDefault("precio", $articulo->getPrecio());
            $this->tag->setDefault("descripcion", $articulo->getDescripcion());
            $this->tag->setDefault("descuento", $articulo->getDescuento());
            $this->tag->setDefault("envio", $articulo->getEnvio());
            
        }
    }

    /**
     * Creates a new articulo
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "articulo",
                'action' => 'index'
            ]);

            return;
        }

        $articulo = new Articulo();
        $articulo->setCodigoCategoria($this->request->getPost("codigo_categoria"));
        $articulo->setCodigoArticulo($this->request->getPost("codigo_articulo"));
        $articulo->setTitulo($this->request->getPost("titulo"));
        $articulo->setPrecio($this->request->getPost("precio"));
        $articulo->setDescripcion($this->request->getPost("descripcion"));
        $articulo->setDescuento($this->request->getPost("descuento"));
        $articulo->setEnvio($this->request->getPost("envio"));


        $id_imagen = $this->request->getPost("codigo_articulo");
        /**$rutas = 'files/'.$id_imagen.'/';
        mkdir($rutas);*/


        if($_FILES["archivo"]["error"]>0){
            echo "Error al cargar archivo";
            } else {


            $permitidos = array("image/gif","image/png","image/jpg");
            $limite_kb = 2000;

            if (in_array($_FILES["archivo"]["type"], $permitidos) && $_FILES["archivo"]["size"] <= $limite_kb * 1024){

                $ruta = 'files/'.$id_imagen.'/';
                $archivo = $ruta.$_FILES["archivo"]["name"];
                $articulo->setRuta($_FILES["archivo"]["name"]);
                if (!file_exists($ruta)){
                    mkdir($ruta);
                }

                if (!file_exists($archivo)) {
                    $resultado = @move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo);

                    if ($resultado) {
                        echo "Archivo Guardado";
                        }else{
                        echo "Error al guardar archivo";
                    }

                    }else{
                        echo "Archivo ya existe";
                        }

                } else {
                echo "Archivo no permitido o tamaño excedido";
            }
        }

        /*unlink('files/'.$id_imagen.'/'.$_FILES["archivo"]["name"]);
        rmdir('files/'.$id_imagen);*/


        if (!$articulo->save()) {
            foreach ($articulo->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "articulo",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("EL ARTICULO SE HA GUARDADO EXITOSAMENTE");

        $this->dispatcher->forward([
            'controller' => "articulo",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a articulo edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "articulo",
                'action' => 'index'
            ]);

            return;
        }

        $codigo_categoria = $this->request->getPost("codigo_categoria");
        $articulo = Articulo::findFirstBycodigo_categoria($codigo_categoria);

        if (!$articulo) {
            $this->flash->error("EL ARTICULO NO EXISTE " . $codigo_categoria);

            $this->dispatcher->forward([
                'controller' => "articulo",
                'action' => 'index'
            ]);

            return;
        }

        $articulo->setCodigoCategoria($this->request->getPost("codigo_categoria"));
        $articulo->setCodigoArticulo($this->request->getPost("codigo_articulo"));
        $articulo->setTitulo($this->request->getPost("titulo"));
        $articulo->setPrecio($this->request->getPost("precio"));
        $articulo->setDescripcion($this->request->getPost("descripcion"));
        $articulo->setDescuento($this->request->getPost("descuento"));
        $articulo->setEnvio($this->request->getPost("envio"));
        

        if (!$articulo->save()) {

            foreach ($articulo->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "articulo",
                'action' => 'edit',
                'params' => [$articulo->getCodigoCategoria()]
            ]);

            return;
        }

        $this->flash->success("EL ARTICULO SE HA MODIFICADO EXITOSAMENTE");

        $this->dispatcher->forward([
            'controller' => "articulo",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a articulo
     *
     * @param string $codigo_categoria
     */
    public function deleteAction($codigo_categoria)
    {
        $articulo = Articulo::findFirstBycodigo_categoria($codigo_categoria);
        if (!$articulo) {
            $this->flash->error("EL ARTICULO NO HA SIDO ENCONTRADO");

            $this->dispatcher->forward([
                'controller' => "articulo",
                'action' => 'index'
            ]);

            return;
        }


        $id_imagen = $articulo->codigo_articulo;
        $taru = $articulo->ruta;

        unlink('files/'.$id_imagen.'/'.$taru);
        rmdir('files/'.$id_imagen);
        

        if (!$articulo->delete()) {

            foreach ($articulo->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "articulo",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("EL ARTICULO SE HA ELIMINADO EXITOSAMENTE");

        $this->dispatcher->forward([
            'controller' => "articulo",
            'action' => "index"
        ]);
    }

}
?>
