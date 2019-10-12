<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use venta\Articulo;

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
        if (count($articulo) == 0) {
            $this->flash->notice("The search did not find any articulo");

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
                $this->flash->error("articulo was not found");

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

        $this->flash->success("articulo was created successfully");

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
            $this->flash->error("articulo does not exist " . $codigo_categoria);

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

        $this->flash->success("articulo was updated successfully");

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
            $this->flash->error("articulo was not found");

            $this->dispatcher->forward([
                'controller' => "articulo",
                'action' => 'index'
            ]);

            return;
        }

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

        $this->flash->success("articulo was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "articulo",
            'action' => "index"
        ]);
    }

}
