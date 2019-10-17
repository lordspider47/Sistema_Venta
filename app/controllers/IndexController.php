<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use venta\Articulo;

class IndexController extends ControllerBase
{

    public function indexAction()
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
            'limit'=> 3,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();

    }

}

