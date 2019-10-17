<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use venta\Imagen;

class ImagenController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for imagen
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, '\venta\Imagen', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "codigo_imagen";

        $imagen = Imagen::find($parameters);
        if (count($imagen) == 0) {
            $this->flash->notice("The search did not find any imagen");

            $this->dispatcher->forward([
                "controller" => "imagen",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $imagen,
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
     * Edits a imagen
     *
     * @param string $codigo_imagen
     */
    public function editAction($codigo_imagen)
    {
        if (!$this->request->isPost()) {

            $imagen = Imagen::findFirstBycodigo_imagen($codigo_imagen);
            if (!$imagen) {
                $this->flash->error("imagen was not found");

                $this->dispatcher->forward([
                    'controller' => "imagen",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->codigo_imagen = $imagen->getCodigoImagen();

            $this->tag->setDefault("codigo_imagen", $imagen->getCodigoImagen());
            $this->tag->setDefault("imagenes", $imagen->getImagenes());
            
        }
    }

    /**
     * Creates a new imagen
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "imagen",
                'action' => 'index'
            ]);

            return;
        }

        $imagen = new Imagen();
        $imagen->setCodigoImagen($this->request->getPost("codigo_imagen"));
        $imagen->setImagenes($this->request->getPost("imagenes"));
        

        if (!$imagen->save()) {
            foreach ($imagen->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "imagen",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("imagen was created successfully");

        $this->dispatcher->forward([
            'controller' => "imagen",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a imagen edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "imagen",
                'action' => 'index'
            ]);

            return;
        }

        $codigo_imagen = $this->request->getPost("codigo_imagen");
        $imagen = Imagen::findFirstBycodigo_imagen($codigo_imagen);

        if (!$imagen) {
            $this->flash->error("imagen does not exist " . $codigo_imagen);

            $this->dispatcher->forward([
                'controller' => "imagen",
                'action' => 'index'
            ]);

            return;
        }

        $imagen->setCodigoImagen($this->request->getPost("codigo_imagen"));
        $imagen->setImagenes($this->request->getPost("imagenes"));
        

        if (!$imagen->save()) {

            foreach ($imagen->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "imagen",
                'action' => 'edit',
                'params' => [$imagen->getCodigoImagen()]
            ]);

            return;
        }

        $this->flash->success("imagen was updated successfully");

        $this->dispatcher->forward([
            'controller' => "imagen",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a imagen
     *
     * @param string $codigo_imagen
     */
    public function deleteAction($codigo_imagen)
    {
        $imagen = Imagen::findFirstBycodigo_imagen($codigo_imagen);
        if (!$imagen) {
            $this->flash->error("imagen was not found");

            $this->dispatcher->forward([
                'controller' => "imagen",
                'action' => 'index'
            ]);

            return;
        }

        if (!$imagen->delete()) {

            foreach ($imagen->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "imagen",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("imagen was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "imagen",
            'action' => "index"
        ]);
    }

}
