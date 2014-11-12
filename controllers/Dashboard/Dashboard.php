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
 * Description of categoriaController
 *
 * @author sam
 */
class Dashboard extends Controller {

    //put your code here
    private $destino;
    private $cabo;

    public function __construct() {
        parent::__construct();

        $this->destino = $this->LoadModelo('Destino');
        $this->cabo = $this->LoadModelo('Cabos');
    }

    public function index($pagina = FALSE) {
        if (!$this->filtraInt($pagina)) {
            $pagina = false;
        } else {
            $pagina = (int) $pagina;
        }


        Session::nivelRestrito(array("usuario", "admin"));
        $this->view->setJs(array('jquery.dataTables'));
        $this->view->setJs(array("dataTables.bootstrap"));
        $this->view->setCss(array('dataTables.bootstrap'));
        $this->view->setJs(array("novo"));

        $this->view->titulo = "Pagina de Administracção";

        $paginador = new \vendor\paginador\Paginador();

        $this->view->destino = $paginador->paginar($this->destino->listaAll(), $pagina, 50);
        //$this->view->paginacao = $paginador->getView('paginacao', 'cabos/index');
        //$this->view->destino = $paginador->paginar($this->destino->listaAll(), $pagina, 50);
        $this->view->renderizar('index');
    }

    public function listarUsuario() {

        $ret = Array("nome" => Session::get('nome'), "mensagem" => "Seja bem vindo a pagina de Administração", "url" => URL);
        echo json_encode($ret);
    }

    public function pesquisar() {
        $teste = $this->cabo->pesquisaId($this->filtraInt($_POST['s']));
        $p = $this->destino->listagem($teste);
        echo json_encode($p);
    }

}
