<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


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
     * Searches for inventario
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Inventario', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id_inventario";

        $inventario = Inventario::find($parameters);
        if (count($inventario) == 0) {
            $this->flash->notice("The search did not find any inventario");

            $this->dispatcher->forward([
                "controller" => "inventario",
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
     * Edits a inventario
     *
     * @param string $id_inventario
     */
    public function editAction($id_inventario)
    {
        if (!$this->request->isPost()) {

            $inventario = Inventario::findFirstByid_inventario($id_inventario);
            if (!$inventario) {
                $this->flash->error("inventario was not found");

                $this->dispatcher->forward([
                    'controller' => "inventario",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id_inventario = $inventario->id_inventario;

            $this->tag->setDefault("id_inventario", $inventario->id_inventario);
            $this->tag->setDefault("cantidad", $inventario->cantidad);
            $this->tag->setDefault("codigo_articulo", $inventario->codigo_articulo);
            
        }
    }

    /**
     * Creates a new inventario
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "inventario",
                'action' => 'index'
            ]);

            return;
        }

        $inventario = new Inventario();
        $inventario->idInventario = $this->request->getPost("id_inventario");
        $inventario->cantidad = $this->request->getPost("cantidad");
        $inventario->codigoArticulo = $this->request->getPost("codigo_articulo");
        

        if (!$inventario->save()) {
            foreach ($inventario->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "inventario",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("inventario was created successfully");

        $this->dispatcher->forward([
            'controller' => "inventario",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a inventario edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "inventario",
                'action' => 'index'
            ]);

            return;
        }

        $id_inventario = $this->request->getPost("id_inventario");
        $inventario = Inventario::findFirstByid_inventario($id_inventario);

        if (!$inventario) {
            $this->flash->error("inventario does not exist " . $id_inventario);

            $this->dispatcher->forward([
                'controller' => "inventario",
                'action' => 'index'
            ]);

            return;
        }

        $inventario->idInventario = $this->request->getPost("id_inventario");
        $inventario->cantidad = $this->request->getPost("cantidad");
        $inventario->codigoArticulo = $this->request->getPost("codigo_articulo");
        

        if (!$inventario->save()) {

            foreach ($inventario->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "inventario",
                'action' => 'edit',
                'params' => [$inventario->id_inventario]
            ]);

            return;
        }

        $this->flash->success("inventario was updated successfully");

        $this->dispatcher->forward([
            'controller' => "inventario",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a inventario
     *
     * @param string $id_inventario
     */
    public function deleteAction($id_inventario)
    {
        $inventario = Inventario::findFirstByid_inventario($id_inventario);
        if (!$inventario) {
            $this->flash->error("inventario was not found");

            $this->dispatcher->forward([
                'controller' => "inventario",
                'action' => 'index'
            ]);

            return;
        }

        if (!$inventario->delete()) {

            foreach ($inventario->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "inventario",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("inventario was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "inventario",
            'action' => "index"
        ]);
    }

}
