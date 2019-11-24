<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use venta\Clientes;

class ClientesController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for clientes
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, '\venta\Clientes', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $clientes = Clientes::find($parameters);
        if (count($clientes) == 0) {
            $this->flash->notice("The search did not find any clientes");

            $this->dispatcher->forward([
                "controller" => "clientes",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $clientes,
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
     * Edits a cliente
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $cliente = Clientes::findFirstByid($id);
            if (!$cliente) {
                $this->flash->error("cliente was not found");

                $this->dispatcher->forward([
                    'controller' => "clientes",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $cliente->getId();

            $this->tag->setDefault("id", $cliente->getId());
            $this->tag->setDefault("trabaja", $cliente->getTrabaja());
            $this->tag->setDefault("estudia", $cliente->getEstudia());
            $this->tag->setDefault("direccion", $cliente->getDireccion());
            $this->tag->setDefault("nombredepadre", $cliente->getNombredepadre());
            $this->tag->setDefault("nombredemadre", $cliente->getNombredemadre());
            $this->tag->setDefault("telefono", $cliente->getTelefono());
            $this->tag->setDefault("activo", $cliente->getActivo());
            $this->tag->setDefault("iduser", $cliente->getIduser());
            
        }
    }

    /**
     * Creates a new cliente
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "clientes",
                'action' => 'index'
            ]);

            return;
        }

        $cliente = new Clientes();
        $cliente->setTrabaja($this->request->getPost("trabaja"));
        $cliente->setEstudia($this->request->getPost("estudia"));
        $cliente->setDireccion($this->request->getPost("direccion"));
        $cliente->setNombredepadre($this->request->getPost("nombredepadre"));
        $cliente->setNombredemadre($this->request->getPost("nombredemadre"));
        $cliente->setTelefono($this->request->getPost("telefono"));
        $cliente->setActivo($this->request->getPost("activo"));
        $cliente->setIduser($this->request->getPost("iduser"));
        

        if (!$cliente->save()) {
            foreach ($cliente->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "clientes",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("cliente was created successfully");

        $this->dispatcher->forward([
            'controller' => "clientes",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a cliente edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "clientes",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $cliente = Clientes::findFirstByid($id);

        if (!$cliente) {
            $this->flash->error("cliente does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "clientes",
                'action' => 'index'
            ]);

            return;
        }

        $cliente->setTrabaja($this->request->getPost("trabaja"));
        $cliente->setEstudia($this->request->getPost("estudia"));
        $cliente->setDireccion($this->request->getPost("direccion"));
        $cliente->setNombredepadre($this->request->getPost("nombredepadre"));
        $cliente->setNombredemadre($this->request->getPost("nombredemadre"));
        $cliente->setTelefono($this->request->getPost("telefono"));
        $cliente->setActivo($this->request->getPost("activo"));
        $cliente->setIduser($this->request->getPost("iduser"));
        

        if (!$cliente->save()) {

            foreach ($cliente->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "clientes",
                'action' => 'edit',
                'params' => [$cliente->getId()]
            ]);

            return;
        }

        $this->flash->success("cliente was updated successfully");

        $this->dispatcher->forward([
            'controller' => "clientes",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a cliente
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $cliente = Clientes::findFirstByid($id);
        if (!$cliente) {
            $this->flash->error("cliente was not found");

            $this->dispatcher->forward([
                'controller' => "clientes",
                'action' => 'index'
            ]);

            return;
        }

        if (!$cliente->delete()) {

            foreach ($cliente->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "clientes",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("cliente was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "clientes",
            'action' => "index"
        ]);
    }

}
