<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Util\Debug;

/**
 * Racks
 *
 * @ORM\Table(name="racks")
 * @ORM\Entity
 */
class Racks {

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
     * @ORM\Column(name="descricao", type="string", length=45, nullable=true)
     */
    private $descricao;

    /**
     * @var \Usuarios
     *
     * @ORM\OneToOne(targetEntity="Usuarios")
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

    public function setId($id) {
        $this->id = $id;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getUsuarios() {
        return $this->usuarios;
    }

    public function setUsuarios(Usuarios $usuarios) {
        $this->usuarios = $usuarios;
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

    public function Insert($objecto) {
        require ROOT . "config/bootstrap.php";
        $usuario = $em->getRepository('models\Usuarios')->findOneBy(array('id' => \application\Session::get('id')));
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
        return $em->getRepository('models\racks')->findby(array(), array("id" => "DESC"));
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

    function listarNome($nome) {
        require ROOT . "config/bootstrap.php";
        return $em->getRepository('models\racks')->findOneBy(array('nome' => $nome));
        $em->flush();
    }

    /*
     * Metodo Update
     * Responsavel pela alteração de todos os  dados no banco onde os valores a serem alterados são passados por parametro
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function Update($dados) {

        require ROOT . "config/bootstrap.php";
        $updat = $em->find('models\racks', $dados->getId());
        $updat->setNome($dados->getNome());
        $updat->setLogin($dados->getLogin());
        $updat->setNivel($dados->getNivel());
        if (!empty($dados->getSenha())) {
            $updat->setSenha(Hash::getHash('md5', $dados->getSenha(), HASH_KEY));
        }
        $em->flush();
    }

    /*
     * Metodo Delete
     * Responsavel pela remoção de dados no banco onde o id é passado por parametro
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function Delete($id) {
        require ROOT . "config/bootstrap.php";
        $excluir = $em->getPartialReference('models\Usuarios', $id);
        $em->remove($excluir);
        $em->flush();
    }

    function listagem() {
        require ROOT . "config/bootstrap.php";
        $t = $em->getRepository('models\Racks');
        $qb = $t->createQueryBuilder('r');
        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

}
