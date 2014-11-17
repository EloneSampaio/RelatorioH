<?php

namespace controllers;

use application\Controller;
use application\Session;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description Dashboard
 *
 * @author sam
 */
class Dashboard extends Controller {

    private $destino;
    private $cabo;

    public function __construct() {
        $this->destino = $this->LoadModelo('Destino');
        $this->cabo = $this->LoadModelo('Cabos');
        parent::__construct();
    }

    public function index($pagina = FALSE) {
        if (!$this->filtraInt($pagina)) {
            $pagina = false;
        } else {
            $pagina = (int) $pagina;
        }


        Session::nivelRestrito(array("usuario", "admin"));

        $this->view->setCss(array('dataTables.bootstrap'));
        $this->view->setCss(array('amaran.min'));
        $this->view->setCss(array('animate.min'));
        $this->view->setCss(array('style'));
        $this->view->setJs(array("jquery.amaran.min"));

        $this->view->setJs(array("novo"));

        $this->view->titulo = "Pagina de Administracção";

        $paginador = new \vendor\paginador\Paginador();
        $this->view->destino = $paginador->paginar($this->destino->listaAll(), $pagina, 50);
        $this->view->renderizar('index');
    }

    public function listarUsuario() {
        if (Session::get('id')) {
            $id = 1;
        }
        $ret = Array("nome" => Session::get('nome'), "mensagem" => "Seja bem vindo a pagina de Administração", "url" => URL);
        echo json_encode($ret);
    }

    public function pesquisar() {
        
    }

}
