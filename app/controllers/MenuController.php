
<?php

use App\Models\Users;

class MenuController extends \Phalcon\Mvc\Controller
{
    protected $idSesion;
    protected $user;
    protected $rol;
    public function initialize(){
        /*comprueba id de sesion */
        if($this->session->has('id'))
        {
            //existencia de sesion permite formatear rol
        $this->idSesion = $this->session->get('id');
        $this->user=Users::findFirst($this->idSesion);
        $this->rol=$this->user->roles->nombre;

        }
        else
        {
            $this->response->redirect('/401'); //redirige a 401 si no existe sesion
        }


    }

    public function adminAction()
    {
        switch($this->rol){
            case 'Vendedor':
            case 'Cliente':
            $this->response->redirect('/401');
        }
        $this->view->pick('layouts/admin');
    }

    public function vendedorAction()
    {

        switch($this->rol){
            case 'Cliente':
            case 'Administrador':
            $this->response->redirect('/401');
        }
        $this->view->pick('layouts/vendedor');
    }

    public function clienteAction()
    {

        switch($this->rol){
            case 'Vendedor':
            case 'Administrador':
            $this->response->redirect('/401');
        }

        $this->view->pick('layouts/cliente');
    }

}