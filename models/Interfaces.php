<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Util\Debug;

/**
 * Interfaces
 *
 * @ORM\Table(name="interfaces", indexes={@ORM\Index(name="fk_interfaces_equipamentos1_idx", columns={"equipamentos_id"}), @ORM\Index(name="fk_interfaces_usuarios1_idx", columns={"usuarios_id"}), @ORM\Index(name="fk_interfaces_patchpanel1_idx", columns={"patchpanel_id"})})
 * @ORM\Entity
 */
class Interfaces {

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
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=20, nullable=false)
     */
    private $descricao;

    /**
     * @var \Equipamentos
     *
     * @ORM\ManyToOne(targetEntity="Equipamentos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipamentos_id", referencedColumnName="id")
     * })
     */
    private $equipamentos;

    /**
     * @var \Patchpanel
     *
     * @ORM\ManyToOne(targetEntity="Patchpanel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="patchpanel_id", referencedColumnName="id")
     * })
     */
    private $patchpanel;

    /**
     * @var \Usuarios
     *
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuarios_id", referencedColumnName="id")
     * })
     */
    private $usuarios;

    public function getUsuarios() {
        return $this->usuarios;
    }

    public function setUsuarios(Usuarios $usuarios) {
        $this->usuarios = $usuarios;
    }

    public function getId() {
        return $this->id;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getEquipamentos() {
        return $this->equipamentos;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setEquipamentos(Equipamentos $equipamentos) {
        $this->equipamentos = $equipamentos;
    }

    public function getPatchpanel() {
        return $this->patchpanel;
    }

    public function setPatchpanel(Patchpanel $patchpanel) {
        $this->patchpanel = $patchpanel;
    }

    /*
     * Metodo Insert
     * Responsavel pela inserção dos dados
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    public function Insert($objecto, $eq = FALSE, $path = FALSE) {
        require ROOT . "config/bootstrap.php";
        if (!empty($eq)) {
            $equipamento = $em->getRepository('models\Equipamentos')->findOneBy(array('id' => $eq));
            $objecto->setEquipamentos($equipamento);
        }
        if (!empty($path)) {
            $patchpanel = $em->getRepository('models\Patchpanel')->findOneBy(array('id' => $path));
            $objecto->setPatchpanel($patchpanel);
        }
        $usuario = $em->getRepository('models\Usuarios')->find(\application\Session::get('id'));
        $objecto->setUsuarios($usuario);
        $em->persist($objecto);
        $em->flush();
        return TRUE;
    }

    /*
     * Metodo listarAll
     * Responsavel pela listagem de todos os  dados
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function listaAll() {
        require ROOT . "config/bootstrap.php";
        return $em->getRepository('models\Interfaces')->findby(array(), array("id" => "DESC"));
        $em->flush();
    }

    /*
     * Metodo listarId
     * Responsavel pela listagem de todos os  dados onde o id é igual ao que é passado pelo paramentro
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function listarId($id) {
        require ROOT . "config/bootstrap.php";
        return $em->getRepository('models\racks')->findOneBy(array('idrack' => $id));
        $em->flush();
    }

    function VerificarInterface($nome, $equip) {
        require ROOT . "config/bootstrap.php";
        return $em->getRepository('models\Interfaces')->findOneBy(array('nome' => $nome, 'equipamentos' => $equip));
        $em->flush();
        return TRUE;
    }

    function VerificarInterfacepatch($nome, $patch) {
        require ROOT . "config/bootstrap.php";
        return $em->getRepository('models\Interfaces')->findOneBy(array('nome' => $nome, 'patchpanel' => $patch));
        $em->flush();
        return TRUE;
    }

    /*
     * Metodo Update
     * Responsavel pela alteração de todos os  dados no banco onde os valores a serem alterados são passados por parametro
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function Update($dados) {

        require ROOT . "config/bootstrap.php";
        $updat = $entityManager->find('models\racks', $dados->getId());
        $updat->setNome($dados->getNome());
        $updat->setLogin($dados->getLogin());
        $updat->setNivel($dados->getNivel());
        if (!empty($dados->getSenha())) {
            $updat->setSenha(Hash::getHash('md5', $dados->getSenha(), HASH_KEY));
        }
        $entityManager->flush();
    }

    /*
     * Metodo Delete
     * Responsavel pela remoção de dados no banco onde o id é passado por parametro
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function Delete($id) {
        require ROOT . "config/bootstrap.php";
        $excluir = $entityManager->getPartialReference('models\Usuarios', $id);
        $entityManager->remove($excluir);
        $entityManager->flush();
    }

    function listagem() {
        require ROOT . "config/bootstrap.php";
        $t = $em->getRepository('models\Interfaces');
        $qb = $t->createQueryBuilder('i');
        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    function pesquisaInterface($id = NULL) {
        require ROOT . "config/bootstrap.php";
        $t = $em->getRepository('models\Interfaces');
        $qb = $em->createQueryBuilder()
                ->select('e.id,e.nome')
                ->from('models\Interfaces', 'e')
                ->where('e.equipamentos = ?1')
                ->setParameter(1, $id);

        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    function pesquisaInterfacePatch($id = NULL) {
        require ROOT . "config/bootstrap.php";
        $t = $em->getRepository('models\Interfaces');
        $qb = $em->createQueryBuilder()
                ->select('e.id,e.nome')
                ->from('models\Interfaces', 'e')
                ->where('e.patchpanel = ?1')
                ->setParameter(1, $id);

        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

}
