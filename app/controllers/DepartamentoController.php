<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use venta\Departamento;

class DepartamentoController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for departamento
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, '\venta\Departamento', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "codigo_departamento";

        $departamento = Departamento::find($parameters);
        if (count($departamento) == 0) {
            $this->flash->notice("The search did not find any departamento");

            $this->dispatcher->forward([
                "controller" => "departamento",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $departamento,
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
     * Edits a departamento
     *
     * @param string $codigo_departamento
     */
    public function editAction($codigo_departamento)
    {
        if (!$this->request->isPost()) {

            $departamento = Departamento::findFirstBycodigo_departamento($codigo_departamento);
            if (!$departamento) {
                $this->flash->error("departamento was not found");

                $this->dispatcher->forward([
                    'controller' => "departamento",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->codigo_departamento = $departamento->getCodigoDepartamento();

            $this->tag->setDefault("codigo_departamento", $departamento->getCodigoDepartamento());
            $this->tag->setDefault("nombre_departamento", $departamento->getNombreDepartamento());
            
        }
    }

    /**
     * Creates a new departamento
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "departamento",
                'action' => 'index'
            ]);

            return;
        }

        $departamento = new Departamento();
        $departamento->setCodigoDepartamento($this->request->getPost("codigo_departamento"));
        $departamento->setNombreDepartamento($this->request->getPost("nombre_departamento"));
        

        if (!$departamento->save()) {
            foreach ($departamento->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "departamento",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("departamento was created successfully");

        $this->dispatcher->forward([
            'controller' => "departamento",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a departamento edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "departamento",
                'action' => 'index'
            ]);

            return;
        }

        $codigo_departamento = $this->request->getPost("codigo_departamento");
        $departamento = Departamento::findFirstBycodigo_departamento($codigo_departamento);

        if (!$departamento) {
            $this->flash->error("departamento does not exist " . $codigo_departamento);

            $this->dispatcher->forward([
                'controller' => "departamento",
                'action' => 'index'
            ]);

            return;
        }

        $departamento->setCodigoDepartamento($this->request->getPost("codigo_departamento"));
        $departamento->setNombreDepartamento($this->request->getPost("nombre_departamento"));
        

        if (!$departamento->save()) {

            foreach ($departamento->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "departamento",
                'action' => 'edit',
                'params' => [$departamento->getCodigoDepartamento()]
            ]);

            return;
        }

        $this->flash->success("departamento was updated successfully");

        $this->dispatcher->forward([
            'controller' => "departamento",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a departamento
     *
     * @param string $codigo_departamento
     */
    public function deleteAction($codigo_departamento)
    {
        $departamento = Departamento::findFirstBycodigo_departamento($codigo_departamento);
        if (!$departamento) {
            $this->flash->error("departamento was not found");

            $this->dispatcher->forward([
                'controller' => "departamento",
                'action' => 'index'
            ]);

            return;
        }

        if (!$departamento->delete()) {

            foreach ($departamento->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "departamento",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("departamento was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "departamento",
            'action' => "index"
        ]);
    }

}
