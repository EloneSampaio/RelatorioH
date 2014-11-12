<?php

namespace controllers;

use application\Controller;
use application\Session;

/**
 * Description of registrarController
 *
 * @author sam
 */
class Patchpanel extends Controller {

    private $patch;
    private $rack;

    public function __construct() {
        $this->patch = $this->LoadModelo('Patchpanel');
        $this->rack = $this->LoadModelo('Racks');
        parent::__construct();
    }

    public function index($pagina = FALSE) {
        $this->view->setJs(array("novo"));

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

        $this->view->titulo = "PATHPANEL";
        $this->view->path = $paginador->paginar($this->patch->listaAll(), $pagina, 5);
        $this->view->paginacao = $paginador->getView('paginacao', 'pathpanel/index');


        if ($this->getInt('enviar') == 1) {
            $this->view->dados = $_POST;


            if (!$this->getSqlverifica('descricao')) {
                // $this->view->erro = "Porfavor Introduza a descricao ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Introduza a descricao");
                echo json_encode($ret);
                exit;
            }

            if (!$this->getInt('tipo')) {
                //$this->view->erro = "Porfavor Introduza o tipo do patchpanel ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Introduza o tipo do patchpanel. exemplo: 24 portas");
                echo json_encode($ret);
                exit;
            }

            if (!$this->getSqlverifica('rack')) {
                //$this->view->erro = "Porfavor Introduza o tipo do patchpanel ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor escolha uma das racks");
                echo json_encode($ret);
                exit;
            }

            $this->patch->setDescricao($this->getSqlverifica('descricao'));
            $this->patch->setTipo($this->getSqlverifica('tipo'));

            if ($this->patch->VerificarNome($this->getSqlverifica('nome'), $this->getSqlverifica('rack'))) {
                //$this->view->erro = "O PatchPanel que tentou criar já existe";
                //$this->view->renderizar('novo');
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "O PatchPanel que tentou criar já existe");
                echo json_encode($ret);
                exit;
            }

            if (!$this->patch->Insert($this->patch, $this->getSqlverifica('rack'))) {
                //$this->view->erro = "erro ao guardar dados";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Erro ao guardar dados");
                echo json_encode($ret);
            } else {

                //$this->view->dados = FALSE;
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Dados guardados com sucesso");
                echo json_encode($ret);
                exit;
            }
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
            $this->redirecionar("radios");
        }
        $this->view->dados = $this->radio->listarId($this->filtraInt($id));


        $this->view->titulo = "Editar Alarme";
        $this->view->setJs(array("novo"));

        if ($this->getInt('enviar') == 1) {

            if (!$this->getSqlverifica('canal')) {
                $this->view->erro = "Porfavor Introduza o  canal ";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('status')) {
                $this->view->erro = "Porfavor Introduza o  status ";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('obs')) {
                $this->view->erro = "POrfavor Introduza um observação";
                $this->view->renderizar("novo");
                exit;
            }


            $this->radio->setCanal($this->getSqlverifica('canal'));
            $this->radio->setStatus($this->getSqlverifica('status'));
            $this->radio->setObs($this->getSqlverifica('obs'));

            $id = $this->view->dados->getId();
            if ($this->radio->Update($this->radio, $id)) {
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
            $this->redirecionar("radios");
        }
        if (!$this->radio->listarId($this->filtraInt($id))) {

            $this->redirecionar("radios");
        }
        $this->radio->Delete($id);
        $this->redirecionar(
                "radios");
    }

    public function listaSelect() {
        $t = $this->rack->listagem();
        echo json_encode($t);
    }

    public function listaPatch() {
        $t = $this->patch->listagem();
        echo json_encode($t);
    }

}
