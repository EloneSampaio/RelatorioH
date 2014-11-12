<?php

namespace controllers;

use application\Controller;
use application\Session;

/**
 * Description of registrarController
 *
 * @author sam
 */
class Racks extends Controller {

    private $rack;

    public function __construct() {
        $this->rack = $this->LoadModelo('Racks');
        parent::__construct();
    }

    public function index($pagina = FALSE) {

        /*
         * @var
         */
        //$this->view->setJs(array("novo"));
        if (!$this->filtraInt($pagina)) {
            $pagina = false;
        } else {
            $pagina = (int) $pagina;
        }

        if (!Session::get('autenticado')) {
            $this->redirecionar();
        }
        $this->view->setJs(array('jquery.dataTables'));
        $this->view->setJs(array("dataTables.bootstrap"));
        $this->view->setCss(array('dataTables.bootstrap'));
        $this->view->setJs(array("novo"));



        $paginador = new \vendor\paginador\Paginador();

        $this->view->titulo = "Racks";
        $this->view->rack = $paginador->paginar($this->rack->listaAll(), $pagina, 50);
        $this->view->paginacao = $paginador->getView('paginacao', 'racks/index');


        if ($this->getInt('enviar') == 1) {
            $this->view->dados = $_POST;


            if (!$this->getSqlverifica('nome')) {
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Introduza o nome");
                echo json_encode($ret);
                exit;
            }
            if (!$this->getSqlverifica('descricao')) {
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "POrfavor Introduza uma descrição");
                echo json_encode($ret);
                exit;
            }

            $this->rack->setNome($this->getSqlverifica('nome'));
            if ($this->rack->listarNome($this->getSqlverifica('nome'))) {
                //$this->view->erro = "A Rack já existe";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "A Rack já existe");
                echo json_encode($ret);
                exit;
            }

            $this->rack->setDescricao($this->getSqlverifica('descricao'));

            if (!$this->rack->Insert($this->rack)) {
                //$this->view->erro = "Erro ao guardar dados";
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Erro ao guardar dados");
                echo json_encode($ret);
                //$this->view->renderizar("novo");
            } else {

                //$this->view->dados = FALSE;
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Dados guardados com sucesso");
                echo json_encode($ret);
                exit;
            }

            //$this->view->mensagem = "Dados guardados com sucesso";
        }

        $this->view->renderizar("index");
    }

    function novo() {

        $this->view->setJs(array("jquery.amaran.min"));
        $this->view->setCss(array('amaran.min'));
        $this->view->setCss(array('animate.min'));
        $this->view->setJs(array("novo"));
        $this->view->setCss(array("style"));
        $this->view->renderizar('novo');
    }

    public function editar($id) {
        Session::nivelRestrito(array("admin"));
        if (!$this->filtraInt($id)) {
            $this->redirecionar("alarmencc");
        }
        $this->view->dados = $this->rack->listarId($this->filtraInt($id));


        $this->view->titulo = "Editar Alarme";
        $this->view->setJs(array("novo"));

        if ($this->getInt('enviar') == 1) {


            if (!$this->getSqlverifica('servicos')) {
                $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('inicio')) {
                $this->view->erro = "Porfavor Introduza o segundo nome do cliente ";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('fim')) {
                $this->view->erro = "POrfavor Introduza um endereço ou morada  valido";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('intervencao_causa')) {
                $this->view->erro = "POrfavor Introduza um endereço ou morada  valido";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('status')) {
                $this->view->erro = "POrfavor Introduza um endereço ou morada  valido";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('obs')) {
                $this->view->erro = "POrfavor Introduza um endereço ou morada  valido";
                $this->view->renderizar("novo");
                exit;
            }


            $this->rack->setServicos($this->getSqlverifica('servicos'));
            $this->rack->setInicio($this->getSqlverifica('inicio'));
            $this->rack->setFim($this->getSqlverifica('fim'));
            $this->rack->setStatus($this->getSqlverifica('status'));
            $this->rack->setObs($this->getSqlverifica('obs'));
            $this->rack->setIntervencaoCausa($this->getSqlverifica('intervencao_causa'));

            $id = $this->view->dados->getId();
            if ($this->rack->Update($this->rack, $id)) {
                $this->view->erro = "Erro ao alterar dados ";
                $this->view->renderizar("editar");
                exit;
            }
            $this->view->mensagem = "Alteração feita com sucesso";
        }

        $this->view->renderizar("editar");
    }

    public function apagar($id) {

        Session::nivelRestrito(array("admin"));

        if (!$this->filtraInt($id)) {
            $this->redirecionar("servicos_logs");
        }
        if (!$this->rack->listarId($this->filtraInt($id))) {
            $this->redirecionar("servicos_logs");
        }
        $this->rack->Delete($id);
        $this->redirecionar("servicos_logs");
    }

    public function listaSelect() {
        $t = $this->rack->listagem();
        echo json_encode($t);
    }

}
