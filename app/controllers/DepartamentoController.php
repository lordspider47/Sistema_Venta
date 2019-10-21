<?php 
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use venta\Departamento;
use venta\Categoria;

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
        if (count($departamento) == 1111111110) {
            $this->flash->notice("NO SE ENCONTRO NINGUNA DEPARTAMENTO CON ESOS DATOS");

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
                $this->flash->error("EL DEPARTAMENTO NO FUE ENCONTRADA");

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
     * Edits a departamento
     *
     * @param string $codigo_departamento
     */
    public function eliminarAction($codigo_departamento)
    {
        if (!$this->request->isPost()) {

            
            $departamento = Departamento::findFirstBycodigo_departamento($codigo_departamento);
            $codigo = $departamento->codigo_departamento;
            $categoria = Categoria::findFirstBycodigo_departamento($codigo);

            
            

            if ($categoria->codigo_departamento == $departamento->codigo_departamento) {

                $this->flash->error("NO SE PUEDE ELIMINAR EL DEPARTAMENTO PORQUE TIENE UNA CATEGORIA ASIGNADA A ESTE");
                $this->dispatcher->forward([
                    "controller" => "departamento",
                    "action" => "search"

                ]);
                return;

            }




            if (!$departamento) {
                $this->flash->error("EL DEPARTAMENTO NO FUE ENCONTRADA");

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

        $codigo_departamento = $this->request->getPost("codigo_departamento");
        $departamento = Departamento::findFirstBycodigo_departamento($codigo_departamento);

        if ($departamento) {
            $this->flash->error("EL CODIGO **". $codigo_departamento ."** YA EXISTE POR FAVOR INGRESE OTRO");

            $this->dispatcher->forward([
                'controller' => "departamento",
                'action' => 'new'
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

        $this->flash->success("DEPARTAMENTO FUE INGRESADO CON EXITO");

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
            $this->flash->error("EL DEPARTAMENTO SE HA MODIFICADO CON EXITO" . $codigo_departamento);

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

        $this->flash->success("EL DEPARTAMENTO SE HA MODIFICADO CON EXITO");

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
            $this->flash->error("departamento no encontrado");

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

        $this->flash->success("DEPARTAMENTO ELIMINADO CON EXITO");

        $this->dispatcher->forward([
            'controller' => "departamento",
            'action' => "index"
        ]);
    }
}