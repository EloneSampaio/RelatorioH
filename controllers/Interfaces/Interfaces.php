<?php

namespace controllers;

use application\Controller;
use application\Session;

/**
 * Description of registrarController
 *
 * @author sam
 */
class Interfaces extends Controller {

    private $interface;
    private $equipamento;

    public function __construct() {
        $this->interface = $this->LoadModelo('Interfaces');
        $this->equipamento = $this->LoadModelo('Equipamentos');
        parent::__construct();
    }

    public function index($pagina = FALSE) {


        $this->view->setJs(array("novo"));

        if (!$this->filtraInt($pagina)) {
            $pagina = false;
        } else {
            $pagina = (int) $pagina;
        }

        if (!Session::get('autenticado')) {
            $this->redirecionar();
        }


        $paginador = new \vendor\paginador\Paginador();

        $this->view->titulo = "INTERFACES";
        $this->view->interface = $paginador->paginar($this->interface->listaAll(), $pagina, 5);
        $this->view->paginacao = $paginador->getView('paginacao', 'interfaces/index');
        if ($this->getInt('enviar') == 1) {
            $this->view->dados = $_POST;


            if (!$this->getSqlverifica('nome')) {
                //  $this->view->erro = "Porfavor Introduza o numero da porta ";
                // $this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Introduza o numero da porta");
                echo json_encode($ret);
                exit;
            }

            if (!$this->getSqlverifica('descricao')) {
                //$this->view->erro = "Porfavor Introduza a descrição ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Introduza a descrição");
                echo json_encode($ret);
                exit;
            }

            if (!(isset($_POST['equipamento']) || isset($_POST['patchpanel']))) {
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Seleciona um equipamento ou patchpanel");
                echo json_encode($ret);
                exit;
            }


            $this->interface->setNome($this->getSqlverifica('nome'));
            $this->interface->setDescricao($this->getSqlverifica('descricao'));

            if ($this->getSqlverifica('equipamento') != NULL && $this->interface->VerificarInterface($this->getSqlverifica('nome'), $this->getSqlverifica('equipamento'))) {
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "A Interface que tentou criar já existe no equipamento");
                echo json_encode($ret);
                exit;
            }

            if ($this->getSqlverifica('patchpanel') != NULL && $this->interface->VerificarInterfacepatch($this->getSqlverifica('nome'), $this->getSqlverifica('patchpanel'))) {
                //$this->view->erro = "A Interface que tentou criar já existe no equipamento";
                //$this->view->renderizar('novo');
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "A Interface que tentou criar já existe no patchpanel");
                echo json_encode($ret);
                exit;
            }

            if (!$this->interface->Insert($this->interface, $this->getSqlverifica('equipamento'), $this->getSqlverifica('patchpanel'))) {
                //$this->view->erro = "erro ao guardar dados";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Erro ao guardar dados");
                echo json_encode($ret);
                exit;
            } else {
                //$this->view->dados = FALSE;
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Dados guardados com sucesso", "status" => 'ok');
                echo json_encode($ret);
                exit;
                //$this->view->mensagem = "Dados guardados com sucesso";
            }
        }
        $this->view->renderizar("index");
    }

    function novo() {

        if (!Session::get('autenticado')) {
            $this->redirecionar();
        }
        $this->view->setJs(array("jquery.amaran.min"));
        $this->view->setJs(array("bootstrap-checkbox"));
        $this->view->setCss(array('amaran.min'));
        $this->view->setCss(array('animate.min'));
        $this->view->setJs(array("novo"));
        $this->view->setCss(array("style"));
        $this->view->renderizar('novo');
    }

    public function editar($id) {
        Session::nivelRestrito(array("admin"));
        if (!$this->filtraInt($id)) {
            $this->redirecionar("identificacao_turnos");
        }
        $this->view->dados = $this->interface->listarId($this->filtraInt($id));


        $this->view->titulo = "Editar Alarme";
        $this->view->setJs(array("novo"));

        if ($this->getInt('enviar') == 1) {
            $this->view->dados = $_POST;


            if (!$this->getSqlverifica('status')) {
                $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('amp')) {
                $this->view->erro = "Porfavor Introduza o segundo nome do cliente ";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('power')) {
                $this->view->erro = "POrfavor Introduza um endereço ou morada  valido";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('tube_temp')) {
                $this->view->erro = "POrfavor Introduza um endereço ou morada  valido";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('obs')) {
                $this->view->erro = "POrfavor Introduza um endereço ou morada  valido";
                $this->view->renderizar("novo");
                exit;
            }
            $this->coyonet->setStatus($this->getSqlverifica('status'));
            $this->coyonet->setAmp($this->getSqlverifica('amp'));
            $this->coyonet->setPower($this->getSqlverifica('power'));
            $this->coyonet->setTubetemp($this->getSqlverifica('tube_temp'));
            $this->coyonet->setObs($this->getSqlverifica('obs'));

            $id = $this->view->dados->getId();
            if ($this->coyonet->Update($this->coyonet, $id)) {
                $this->view->erro = "Erro ao alterar dados ";
                $this->view->renderizar("editar");
                exit;
            }
            $this->view->mensagem = "Alteração feita com sucesso";
        }

        $this->view->
                renderizar("editar");
    }

    public function apagar($id) {

        Session::nivelRestrito(array("admin"));

        if (!$this->filtraInt($id)) {
            $this->redirecionar("identificacao_turnos");
        }
        if (!$this->interface->listarId($this->filtraInt($id))) {
            $this->redirecionar("identificacao_turnos");
        }
        $this->interface->Delete($id);
        $this->redirecionar("identificacao_turnos");
    }

    public function listaInterface() {
        $t = $this->interface->listagem();
        echo json_encode($t);
        exit;
    }

    public function pesquisaInterface() {
        $t = $this->interface->pesquisaInterface($_GET['id']);
        echo json_encode($t);
        exit;
    }

    public function pesquisaInterfacePatchs() {
        $t = $this->interface->pesquisaInterfacePatch($_GET['id']);
        echo json_encode($t);
        exit;
    }

}
