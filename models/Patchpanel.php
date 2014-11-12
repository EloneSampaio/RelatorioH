<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Util\Debug;

/**
 * Patchpanel
 *
 * @ORM\Table(name="patchpanel", indexes={@ORM\Index(name="fk_patchpanel_racks1_idx", columns={"racks_id"})})
 * @ORM\Entity
 */
class Patchpanel {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=45, nullable=true)
     */
    private $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=45, nullable=true)
     */
    private $tipo;

    /**
     * @var \Racks
     *
     * @ORM\ManyToOne(targetEntity="Racks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="racks_id", referencedColumnName="id")
     * })
     */
    private $racks;

    /**
     * @var \Usuarios
     *
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuarios_id", referencedColumnName="id")
     * })
     */
    private $usuarios;

    public function getId() {
        return $this->id;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getRacks() {
        return $this->racks;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setRacks(Racks $racks) {
        $this->racks = $racks;
    }

    public function getUsuarios() {
        return $this->usuarios;
    }

    public function setUsuarios(Usuarios $usuarios) {
        $this->usuarios = $usuarios;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    /*
     * Metodo Insert
     * Responsavel pela inserção dos dados
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    public function Insert($objecto, $r) {
        $nome = "PP";
        require ROOT . "config/bootstrap.php";
        $rack = $em->getRepository('models\Racks')->findOneBy(array('id' => $r));
        $usuario = $em->getRepository('models\Usuarios')->find(\application\Session::get('id'));
        $this->setNome($nome . $r);
        $objecto->setUsuarios($usuario);
        $objecto->setRacks($rack);
        $em->persist($objecto);
        $em->flush();
        return True;
    }

    /*
     * Metodo listarAll
     * Responsavel pela listagem de todos os  dados
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function listaAll() {
        require ROOT . "config/bootstrap.php";
        return $em->getRepository('models\Patchpanel')->findby(array(), array("id" => "DESC"));
        $em->flush();
    }

    /*
     * Metodo listarId
     * Responsavel pela listagem de todos os  dados onde o id é igual ao que é passado pelo paramentro
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function listarId($id) {
        require ROOT . "config/bootstrap.php";
        return $em->getRepository('models\Patchpanel')->findOneBy(array('id' => $id));
        $em->flush();
    }

    /*
     * Metodo Update
     * Responsavel pela alteração de todos os  dados no banco onde os valores a serem alterados são passados por parametro
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function Update($dados) {

        require ROOT . "config/bootstrap.php";
        $updat = $entityManager->find('models\Patchpanel', $dados->getId());

        $entityManager->flush();
    }

    /*
     * Metodo Delete
     * Responsavel pela remoção de dados no banco onde o id é passado por parametro
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function Delete($id) {
        require ROOT . "config/bootstrap.php";
        $excluir = $entityManager->getPartialReference('models\Patchpanel', $id);
        $entityManager->remove($excluir);
        $entityManager->flush();
    }

    function listagem() {
        require ROOT . "config/bootstrap.php";
        $t = $em->getRepository('models\Patchpanel');
        $qb = $t->createQueryBuilder('p');
        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    function VerificarNome($nome, $id) {
        require ROOT . "config/bootstrap.php";
        $nome = "PP" . $id;
        return $em->getRepository('models\Patchpanel')->findOneBy(array('nome' => $nome));
        $em->flush();
    }

}
