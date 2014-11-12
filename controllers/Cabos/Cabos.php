<?php

namespace controllers;

use application\Controller;
use application\Session;

/**
 * Description of registrarController
 *
 * @author sam
 */
class Cabos extends Controller {

    //put your code here

    private $cabo;

    /**
     *
     * @var $patch \models\Patchpanel
     */
    private $patch;
    private $interface;
    private $destino;

    public function __construct() {
        $this->cabo = $this->LoadModelo('Cabos');
        $this->patch = $this->LoadModelo('Patchpanel');
        $this->interface = $this->LoadModelo('Interfaces');
        $this->destino = $this->LoadModelo('Destino');
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

        $paginador = new \vendor\paginador\Paginador();

        $this->view->titulo = "Cabos";
        $this->view->destino = $paginador->paginar($this->destino->listaAll(), $pagina, 5);
        $this->view->paginacao = $paginador->getView('paginacao', 'cabos/index');


        if ($this->getInt('enviar') == 1) {
            $this->view->dados = $_POST;


            if (!$this->getSqlverifica('cor')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Escolha uma cor");
                echo json_encode($ret);
                exit;
            }

            if (!$this->getSqlverifica('codigo')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Escolha uma cor");
                echo json_encode($ret);
                exit;
            }

            if (!$this->getSqlverifica('tipo')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Escolha um tipo");
                echo json_encode($ret);
                exit;
            }

            if (!$this->getSqlverifica('descricao')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Introduza  uma descricao");
                echo json_encode($ret);
                exit;
            }

            if (!$this->getSqlverifica('equipamento')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor seleciona uma das portas do equipamento");
                echo json_encode($ret);
                exit;
            }

            if (!$this->getSqlverifica('patchpanel')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor seleciona uma das portas do equipamento");
                echo json_encode($ret);
                exit;
            }

            if (!$this->getSqlverifica('equipamento_porta')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor seleciona uma das portas do equipamento");
                echo json_encode($ret);
                exit;
            }



            if (!$this->getSqlverifica('patchpanel_porta')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor seleciona uma das portas do patchpanel");
                echo json_encode($ret);
                exit;
            }
            //Dados da origem dou cabo fim///


            $this->cabo->setCor($this->getSqlverifica('cor'));
            $this->cabo->setCodigo($this->getSqlverifica('codigo'));
            $this->cabo->setTipo($this->getSqlverifica('tipo'));
            $this->cabo->setDescricao($this->getSqlverifica('descricao'));
            $this->cabo->setEquipamentosPorta($this->getSqlverifica('equipamento_porta'));
            $this->cabo->setPatchpanelPorta($this->getSqlverifica('patchpanel_porta'));


            //dados do destino//


            if (!$this->getSqlverifica('cor1')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Escolha uma cor do cabo de destino");
                echo json_encode($ret);
                exit;
            }

            if (!$this->getSqlverifica('tipo1')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Escolha um tipo de cabo do destino");
                echo json_encode($ret);
                exit;
            }

            if (!$this->getSqlverifica('descricao1')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Introduza  uma descricao do cabo de destino");
                echo json_encode($ret);
                exit;
            }

            if (!$this->getSqlverifica('equipamento1')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor seleciona uma das portas do equipamento de destino");
                echo json_encode($ret);
                exit;
            }

            if (!$this->getSqlverifica('patchpanel1')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor seleciona uma das portas do patchpanel de destino");
                echo json_encode($ret);
                exit;
            }

            if (!$this->getSqlverifica('equipamento_porta1')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor seleciona uma das portas do equipamento de destino");
                echo json_encode($ret);
                exit;
            }



            if (!$this->getSqlverifica('patchpanel_porta1')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor seleciona uma das portas do patchpanel de destino");
                echo json_encode($ret);
                exit;
            }


            $this->destino->setCodigo($this->getSqlverifica('codigo1'));
            $this->destino->setCor($this->getSqlverifica('cor1'));
            $this->destino->setTipo($this->getSqlverifica('tipo1'));
            $this->destino->setDescricao($this->getSqlverifica('descricao1'));
            $this->destino->setEquipamentosPorta($this->getSqlverifica('equipamento_porta1'));
            $this->destino->setPatchpanelPorta($this->getSqlverifica('patchpanel_porta1'));


            //dados do destino

            if (!$t = $this->cabo->Insert($this->cabo, $this->getSqlverifica('equipamento'), $this->getSqlverifica('patchpanel'))) {
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Erro ao guardar dados");
                echo json_encode($ret);
                exit;
            } else {
                if (!$this->destino->Insert($this->destino, $this->getSqlverifica('equipamento1'), $this->getSqlverifica('patchpanel1'), $t)) {
                    $ret = Array("nome" => Session::get('nome'), "mensagem" => "Erro ao guardar dados");
                    echo json_encode($ret);
                    exit;
                } else {
                    $ret = Array("nome" => Session::get('nome'), "mensagem" => "Dados guardados com sucesso", "status" => "ok");
                    echo json_encode($ret);
                    exit;
                }
            }
        }
        $this->view->renderizar("index");
    }

    function novo() {
        $this->view->setJs(array("bootstrap-checkbox"));
        $this->view->setJs(array("jquery.amaran.min"));
        $this->view->setCss(array('amaran.min'));
        $this->view->setCss(array('animate.min'));
        $this->view->setJs(array("novo"));
        //$this->view->setCss(array("style"));
        $this->view->renderizar('novo');
    }

    public function editar($id) {
        Session::nivelRestrito(array("admin"));
        if (!$this->filtraInt($id)) {
            $this->redirecionar("alarmencc");
        }
        $this->view->dados = $this->cabo->listarId($this->filtraInt($id));


        $this->view->titulo = "Editar Alarme";
        $this->view->setJs(array("novo"));

        if ($this->getInt('enviar') == 1) {



            if (!$this->getSqlverifica('criated')) {
                $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('severity')) {
                $this->view->erro = "Porfavor Introduza o segundo nome do cliente ";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('device_service')) {
                $this->view->erro = "POrfavor Introduza um endereço ou morada  valido";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('details')) {
                $this->view->erro = "POrfavor Introduza um endereço ou morada  valido";
                $this->view->renderizar("novo");
                exit;
            }

            $this->cabo->setSeverity($this->getSqlverifica('severity'));
            $this->cabo->setDeviceService($this->getSqlverifica('device_service'));
            $this->cabo->setDetails($this->getSqlverifica('details'));
            $this->cabo->setCriated($this->getSqlverifica('criated'));

            $id = $this->view->dados->getId();
            if ($this->cabo->Update($this->cabo, $id)) {
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
            $this->redirecionar("alarmencc");
        }
        if (!$this->cabo->listarId($this->filtraInt($id))) {
            $this->redirecionar("alarmencc");
        }
        $this->cabo->Delete($id);
        $this->redirecionar("alarmencc");
    }

}
