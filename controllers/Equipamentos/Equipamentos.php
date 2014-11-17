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
class Equipamentos extends Controller {

    private $equipamento;
    private $propriedade;

    public function __construct() {
        $this->equipamento = $this->LoadModelo('Equipamentos');
        $this->propriedade = $this->LoadModelo('Propriedade');
        parent::__construct();
    }

    public function index($pagina = FALSE) {

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

        $this->view->titulo = "EQUIPAMENTOS";
        $this->view->equipamento = $paginador->paginar($this->equipamento->listaAll(), $pagina, 5);
        $this->view->paginacao = $paginador->getView('paginacao', 'alarmencc/index');


        if ($this->getInt('enviar') == 1) {
            $this->view->dados = $_POST;

//            print_r($_POST['contacts']); 
//          
//            exit;

            if (!$this->getSqlverifica('nome')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Introduza um nome");
                echo json_encode($ret);
                exit;
            }

            if (!$this->getSqlverifica('descricao')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Introduza a descricao");
                echo json_encode($ret);
                exit;
            }


            if (!$this->getSqlverifica('tipo')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor introduza um tipo. exemplo: switch");
                echo json_encode($ret);
                exit;
            }

            if (!$this->getInt('rack')) {
                // $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                //$this->view->renderizar("novo");
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor seleciona uma das racks");
                echo json_encode($ret);
                exit;
            }


            if (isset($_POST['produtos'])){
                foreach ($_POST['produtos'] as $p):
                    $m = $p[1];
                    $m1 = $p[2];
                    $m2 = $p['3'];
                endforeach;
                
            }


            $this->equipamento->setNome($this->getSqlverifica('nome'));
            $this->equipamento->setDescricao($this->getSqlverifica('descricao'));
            $this->equipamento->setTipo($this->getSqlverifica('tipo'));



            if (!$t=$this->equipamento->Insert($this->equipamento, $this->getInt('rack'))) {
                $ret = Array("nome" => Session::get('nome'), "mensagem" => "Erro ao guardar dados");
                echo json_encode($ret);
            } else {
                $this->view->dados = FALSE;

                $this->propriedade->setChave('teste');
                $this->propriedade->setChave('teste1');
                $this->propriedade->setChave('teste2');
                $this->propriedade->setValor($m);
                $this->propriedade->setValor($m1);
                 $this->propriedade->setValor($m2);
                
                $this->propriedade->Insert($this->propriedade,$t);
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
        $this->view->setJs(array("formadd"));
        $this->view->setJs(array("novo"));
        $this->view->setCss(array("style"));
        $this->view->renderizar('novo');
    }

    public function editar($id) {
        Session::nivelRestrito(array("admin"));
        if (!$this->filtraInt($id)) {
            $this->redirecionar("coyonet_hpas");
        }
        $this->view->dados = $this->equipamento->listarId($this->filtraInt($id));


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
            $this->equipamento->setStatus($this->getSqlverifica('status'));
            $this->equipamento->setAmp($this->getSqlverifica('amp'));
            $this->equipamento->setPower($this->getSqlverifica('power'));
            $this->equipamento->setTubetemp($this->getSqlverifica('tube_temp'));
            $this->equipamento->setObs($this->getSqlverifica('obs'));

            $id = $this->view->dados->getId();
            if ($this->equipamento->Update($this->equipamento, $id)) {
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
            $this->redirecionar("coyonet_hpas");
        }
        if (!$this->equipamento->listarId($this->filtraInt($id))) {
            $this->redirecionar("coyonet_hpas");
        }
        $this->equipamento->Delete($id);
        $this->redirecionar("coyonet_hpas");
    }

    public function listaEquipamento() {
        $t = $this->equipamento->listagem();
        header('Content-Type: application/json', true);
        echo json_encode($t);
    }

}
