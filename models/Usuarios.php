<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Util\Debug;

/**
 * Usuarios
 *
 * @ORM\Table(name="usuarios")
 * @ORM\Entity
 */
class Usuarios {

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
     * @ORM\Column(name="nome", type="string", length=40, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=20, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="senha", type="string", length=100, nullable=false)
     */
    private $senha;

    /**
     * @var \Grupo
     *
     * @ORM\ManyToOne(targetEntity="Grupo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="grupo_id", referencedColumnName="id")
     * })
     */
    private $grupo;

    public function getGrupo() {
        return $this->grupo;
    }

    public function setGrupo(Grupo $grupo) {
        $this->grupo = $grupo;
    }

    public function getIdUsuario() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setId($id) {
        $this->id = $id;
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
        $entityManager->persist($objecto);
        $entityManager->flush();
    }

    /*
     * Metodo listarAll
     * Responsavel pela listagem de todos os  dados
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function listaAll() {
        require ROOT . "config/bootstrap.php";
        return $em->getRepository('models\Usuarios')->findby(array(), array("id" => "DESC"));
        $em->flush();
    }

    /*
     * Metodo listarNome
     * Responsavel pela listagem de todos os  dados onde o nome é igual ao que é passado pelo paramentro
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function listarNome($nome) {
        require ROOT . "config/bootstrap.php";
        return $em->getRepository('models\Usuarios')->findOneBy(array('nome' => $nome));
        $em->flush();
    }

    /*
     * Metodo listarLogin
     * Responsavel pela listagem de todos os  dados onde o nome é igual ao que é passado pelo paramentro
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function listarLogin($login) {
        require ROOT . "config/bootstrap.php";
        return $em->getRepository('models\Usuarios')->find($login);
        $em->flush();
    }

    /*
     * Metodo listarId
     * Responsavel pela listagem de todos os  dados onde o id é igual ao que é passado pelo paramentro
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function listarId($id) {
        require ROOT . "config/bootstrap.php";
        return $entityManager->getRepository('models\Usuarios')->findOneBy(array('id' => $id));
        $entityManager->flush();
    }

    /*
     * Metodo Update
     * Responsavel pela alteração de todos os  dados no banco onde os valores a serem alterados são passados por parametro
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function Update($dados) {

        require ROOT . "config/bootstrap.php";
        $updat = $entityManager->find('models\Usuarios', $dados->getId());
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

    /*
     * Metodo Autenticar
     * Responsavel pela autenticação do usuario na aplicação
     * @objecto->contem o login e senha do usuario
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function Autenticar($objecto) {

        //require $this->db;
        require ROOT . "config/bootstrap.php";
        return $em->getRepository('models\Usuarios')->findOneBy(array('login' => $objecto->getLogin(), 'senha' => $objecto->getSenha()));
//        $grupo = $em->getRepository('models\Grupo')->findOneBy(array('grupo_id' => $usuario));
        $em->flush();
        
    }

}
