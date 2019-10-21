<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use venta\Categoria;
use venta\Articulo;
use venta\Departamento;

class CategoriaController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for categoria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, '\venta\Categoria', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "codigo_categoria";

        $categoria = Categoria::find($parameters);
        if (count($categoria) == 111111111110) {
            $this->flash->notice("NO SE ENCONTRO NINGUNA CATEGORIA CON ESOS DATOS");

            $this->dispatcher->forward([
                "controller" => "categoria",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $categoria,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction($codigo_departamento)
    {
        $departamento = Departamento::findFirstBycodigo_departamento($codigo_departamento);
        $this->view->codigo_departamento = $departamento->getCodigoDepartamento();
        $this->tag->setDefault("codigo_departamento", $departamento->getCodigoDepartamento());

    }

    /**
     * Edits a categoria
     *
     * @param string $codigo_categoria
     */
    public function editAction($codigo_categoria)
    {
        if (!$this->request->isPost()) {

            $categoria = Categoria::findFirstBycodigo_categoria($codigo_categoria);
            if (!$categoria) {
                $this->flash->error("LA CATEGORIA NO FUE ENCONTRADA");

                $this->dispatcher->forward([
                    'controller' => "categoria",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->codigo_categoria = $categoria->getCodigoCategoria();

            $this->tag->setDefault("codigo_categoria", $categoria->getCodigoCategoria());
            $this->tag->setDefault("nombre_categoria", $categoria->getNombreCategoria());
            $this->tag->setDefault("codigo_departamento", $categoria->getCodigoDepartamento());
            
        }
    }

    /**
     * Eliminar a categoria
     *
     * @param string $codigo_categoria
     */

    public function eliminarAction($codigo_categoria)
    {
        if (!$this->request->isPost()) {

            $categoria = Categoria::findFirstBycodigo_categoria($codigo_categoria);
            $articulo = Articulo::findFirstBycodigo_categoria($codigo_categoria);

            /*if (count($articulo->codigo_categoria) == 0) {
                $this->flash->success("SE PUEDE ELIMINAR LA CATEGORIA PORQUE TIENE ARTICULOS ASIGNADOS A ESTA");
                $this->dispatcher->forward([
                    "controller" => "categoria",
                    "action" => "search"

                ]);
                return;
                
            } */

            

            if ($categoria->codigo_categoria == $articulo->codigo_categoria) {

                $this->flash->error("NO SE PUEDE ELIMINAR LA CATEGORIA PORQUE TIENE ARTICULOS ASIGNADOS A ESTA");
                $this->dispatcher->forward([
                    "controller" => "categoria",
                    "action" => "search"

                ]);
                return;

            } /*else {
                $this->flash->success("SE PUEDE ELIMINAR LA CATEGORIA PORQUE TIENE ARTICULOS ASIGNADOS A ESTA");
                $this->dispatcher->forward([
                    "controller" => "categoria",
                    "action" => "eliminar"

                ]);
                return;

            }*/

            /*if (count($articulo->codigo_categoria) == 111111111110) {
            $this->flash->notice("NO SE ENCONTRO NINGUNA CATEGORIA CON ESOS DATOS");

            $this->dispatcher->forward([
                "controller" => "categoria",
                "action" => "index"
            ]);

            return;
        }*/



            /*if (!$categoria) {
                $this->flash->error("LA CATEGORIA NO FUE ENCONTRADA");

                $this->dispatcher->forward([
                    'controller' => "categoria",
                    'action' => 'index'
                ]);

                return;
            }*/

            $this->view->codigo_categoria = $categoria->getCodigoCategoria();

            $this->tag->setDefault("codigo_categoria", $categoria->getCodigoCategoria());
            $this->tag->setDefault("nombre_categoria", $categoria->getNombreCategoria());
            $this->tag->setDefault("codigo_departamento", $categoria->getCodigoDepartamento());
            
        }
    }

    /**
     * Creates a new categoria
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "categoria",
                'action' => 'index'
            ]);

            return;
        }

        $codigo_categoria = $this->request->getPost("codigo_categoria");
        $categoria = Categoria::findFirstBycodigo_categoria($codigo_categoria);

        if ($categoria) {
            $this->flash->error("EL CODIGO **". $codigo_categoria. "** DE CATEGORIA YA EXISTE, POR FAVOR INGRESE OTRO " );

            $this->dispatcher->forward([
                'controller' => "departamento",
                'action' => 'search'
            ]);

            return;
        }

        $categoria = new Categoria();
        $categoria->setCodigoCategoria($this->request->getPost("codigo_categoria"));
        $categoria->setNombreCategoria($this->request->getPost("nombre_categoria"));
        $categoria->setCodigoDepartamento($this->request->getPost("codigo_departamento"));
        

        if (!$categoria->save()) {
            foreach ($categoria->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "categoria",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("LA CATEGORIA FUE INGRESADA CON EXITO");

        $this->dispatcher->forward([
            'controller' => "categoria",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a categoria edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "categoria",
                'action' => 'index'
            ]);

            return;
        }

        $codigo_categoria = $this->request->getPost("codigo_categoria");
        $categoria = Categoria::findFirstBycodigo_categoria($codigo_categoria);

        if (!$categoria) {
            $this->flash->error("LA CATEGORIA NO EXISTE " . $codigo_categoria);

            $this->dispatcher->forward([
                'controller' => "categoria",
                'action' => 'index'
            ]);

            return;
        }

        $categoria->setCodigoCategoria($this->request->getPost("codigo_categoria"));
        $categoria->setNombreCategoria($this->request->getPost("nombre_categoria"));
        $categoria->setCodigoDepartamento($this->request->getPost("codigo_departamento"));
        

        if (!$categoria->save()) {

            foreach ($categoria->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "categoria",
                'action' => 'edit',
                'params' => [$categoria->getCodigoCategoria()]
            ]);

            return;
        }

        $this->flash->success("LA CATEGORIA SE HA MODIFICADO EXITOSAMENTE");

        $this->dispatcher->forward([
            'controller' => "categoria",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a categoria
     *
     * @param string $codigo_categoria
     */
    public function deleteAction($codigo_categoria)
    {
        $categoria = Categoria::findFirstBycodigo_categoria($codigo_categoria);
        if ($categoria > 0) {
            # code...
        }



        if (!$categoria) {
            $this->flash->error("CATEGORIA NO ENCONTRADA");

            $this->dispatcher->forward([
                'controller' => "categoria",
                'action' => 'index'
            ]);

            return;
        }

        if (!$categoria->delete()) {

            foreach ($categoria->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "categoria",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("LA CATEGORIA SE HA BORRADO EXITOSAMENTE");

        $this->dispatcher->forward([
            'controller' => "categoria",
            'action' => "index"
        ]);
    }

}
