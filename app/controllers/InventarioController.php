<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
<<<<<<< HEAD
use venta\Inventario;
=======
use Articulo;

>>>>>>> 601dabf6e373270d9561c42bc03d792db630d8c5

class InventarioController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for Inventario
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, '\venta\Inventario', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "codigo_articulo";

        $inventario = Inventario::find($parameters);
        if (count($inventario) == 0) {
<<<<<<< HEAD
            $this->flash->notice("The search did not find any Inventario");
=======
            $this->flash->notice("La búsqueda no encontró ningún articulo en inventario");
>>>>>>> 601dabf6e373270d9561c42bc03d792db630d8c5

            $this->dispatcher->forward([
                "controller" => "Inventario",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $inventario,
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
     * Edits a Inventario
     *
     * @param string $codigo_articulo
     */
    public function editAction($codigo_articulo)
    {
        if (!$this->request->isPost()) {

            $inventario = Inventario::findFirstBycodigo_articulo($codigo_articulo);
            if (!$inventario) {
<<<<<<< HEAD
                $this->flash->error("Inventario was not found");
=======
                $this->flash->error("no se encontró articulo en inventario");
>>>>>>> 601dabf6e373270d9561c42bc03d792db630d8c5

                $this->dispatcher->forward([
                    'controller' => "Inventario",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->codigo_articulo = $inventario->getCodigoArticulo();

            $this->tag->setDefault("codigo_articulo", $inventario->getCodigoArticulo());
            $this->tag->setDefault("id_inventario", $inventario->getIdInventario());
            $this->tag->setDefault("cantidad", $inventario->getCantidad());
            
        }
    }

    /**
     * Creates a new Inventario
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "Inventario",
                'action' => 'index'
            ]);

            return;
        }

        $inventario = new Inventario();
        $inventario->setCodigoArticulo($this->request->getPost("codigo_articulo"));
        $inventario->setIdInventario($this->request->getPost("id_inventario"));
        $inventario->setCantidad($this->request->getPost("cantidad"));
        

        if (!$inventario->save()) {
            foreach ($inventario->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "Inventario",
                'action' => 'new'
            ]);

            return;
        }

<<<<<<< HEAD
        $this->flash->success("Inventario was created successfully");
=======
        $this->flash->success("articulo fue agregado al inventario con éxito");
>>>>>>> 601dabf6e373270d9561c42bc03d792db630d8c5

        $this->dispatcher->forward([
            'controller' => "Inventario",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a Inventario edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "Inventario",
                'action' => 'index'
            ]);

            return;
        }

        $codigo_articulo = $this->request->getPost("codigo_articulo");
        $inventario = Inventario::findFirstBycodigo_articulo($codigo_articulo);

        if (!$inventario) {
<<<<<<< HEAD
            $this->flash->error("Inventario does not exist " . $codigo_articulo);
=======
            $this->flash->error("el articulo en el inventario no existe" . $id_inventario);
>>>>>>> 601dabf6e373270d9561c42bc03d792db630d8c5

            $this->dispatcher->forward([
                'controller' => "Inventario",
                'action' => 'index'
            ]);

            return;
        }

        $inventario->setCodigoArticulo($this->request->getPost("codigo_articulo"));
        $inventario->setIdInventario($this->request->getPost("id_inventario"));
        $inventario->setCantidad($this->request->getPost("cantidad"));
        

        if (!$inventario->save()) {

            foreach ($inventario->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "Inventario",
                'action' => 'edit',
                'params' => [$inventario->getCodigoArticulo()]
            ]);

            return;
        }

<<<<<<< HEAD
        $this->flash->success("Inventario was updated successfully");
=======
        $this->flash->success("inventario fue actualizado con éxito");
>>>>>>> 601dabf6e373270d9561c42bc03d792db630d8c5

        $this->dispatcher->forward([
            'controller' => "Inventario",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a Inventario
     *
     * @param string $codigo_articulo
     */
    public function deleteAction($codigo_articulo)
    {
        $inventario = Inventario::findFirstBycodigo_articulo($codigo_articulo);
        if (!$inventario) {
<<<<<<< HEAD
            $this->flash->error("Inventario was not found");
=======
            $this->flash->error("no se encontró articulo en inventario");
>>>>>>> 601dabf6e373270d9561c42bc03d792db630d8c5

            $this->dispatcher->forward([
                'controller' => "Inventario",
                'action' => 'index'
            ]);

            return;
        }

        if (!$inventario->delete()) {

            foreach ($inventario->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "Inventario",
                'action' => 'search'
            ]);

            return;
        }

<<<<<<< HEAD
        $this->flash->success("Inventario was deleted successfully");
=======
        $this->flash->success("el articulo en el inventario fue eliminado con éxito");
>>>>>>> 601dabf6e373270d9561c42bc03d792db630d8c5

        $this->dispatcher->forward([
            'controller' => "Inventario",
            'action' => "index"
        ]);
    }

}
