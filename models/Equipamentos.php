<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Util\Debug;

/**
 * Equipamentos
 *
 * @ORM\Table(name="equipamentos", indexes={@ORM\Index(name="fk_equipamentos_racks_idx", columns={"racks_id"}), @ORM\Index(name="fk_equipamentos_usuarios1_idx", columns={"usuarios_id"})})
 * @ORM\Entity
 */
class Equipamentos {

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
     * @ORM\Column(name="nome", type="string", length=45, nullable=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=45, nullable=true)
     */
    private $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="integer", length=45, nullable=true)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="modelo", type="string", length=45, nullable=true)
     */
    private $modelo;

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

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getModelo() {
        return $this->modelo;
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

    public function setModelo($modelo) {
        $this->modelo = $modelo;
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

    /*
     * Metodo Insert
     * Responsavel pela inserção dos dados
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     * 
     */

    public function Insert($objecto, $rack) {
        require ROOT . "config/bootstrap.php";

        $rack = $em->getRepository('models\Racks')->findOneBy(array('id' => $rack));
        $usuario = $em->getRepository('models\Usuarios')->findOneBy(array('id' => \application\Session::get('id')));
        $objecto->setUsuarios($usuario);
        $objecto->setRacks($rack);
        $em->persist($objecto);
        $em->flush();
        return True;
    }

    function listarEquip($id) {
        require ROOT . "config/bootstrap.php";
        $eq = $em->getRepository('models\Equipamentos')->findOneBy(array('id' => $t));

//        print $eq->getDescricao();
//        print $eq->getRacks()->getNomeRack();
//        print $eq->getRacks()->getDescricao();
//                ->getNome();
    }

    /*
     * Metodo listarAll
     * Responsavel pela listagem de todos os  dados
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function listaAll() {
        require ROOT . "config/bootstrap.php";
        return $em->getRepository('models\Equipamentos')->findby(array(), array("id" => "DESC"));
        $em->flush();
    }

    /*
     * Metodo Update
     * Responsavel pela alteração de todos os  dados no banco onde os valores a serem alterados são passados por parametro
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function Update($dados) {

        require ROOT . "config/bootstrap.php";
        $updat = $em->find('models\Equipamentos', $dados->getId());
        $updat->setNome($dados->getNome());
        $updat->setLogin($dados->getLogin());
        $updat->setNivel($dados->getNivel());
        if (!empty($dados->getSenha())) {
            $updat->setSenha(Hash::getHash('md5', $dados->getSenha(), HASH_KEY));
        }
        $em->flush();
    }

    function pesquisa($pesquisa) {
        require ROOT . "config/bootstrap.php";
        $repo = $em->getRepository('models\Equipamentos');
        $query = $repo->createQueryBuilder('e')
                ->where('e.nome LIKE :pesquisa')
                ->orWhere('e.descricao LIKE :pesquisa')
                ->setParameter('pesquisa', '%' . $pesquisa . '%')
                ->getQuery();
        $t = $query->getResult();

        foreach ($t as $m):
            print $m->nome;
        endforeach;
        exit;
    }

    /*
     * Metodo Delete
     * Responsavel pela remoção de dados no banco onde o id é passado por parametro
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function Delete($id) {
        require ROOT . "config/bootstrap.php";
        $excluir = $entityManager->getPartialReference('models\Equipamentos', $id);
        $entityManager->remove($excluir);
        $entityManager->flush();
    }

    function pesquisaEquipamentos($id = NULL) {
        require ROOT . "config/bootstrap.php";
        $t = $em->getRepository('models\Equipamentos');
        $qb = $em->createQueryBuilder()
                ->select('e.id', 'e.nome')
                ->from('models\Equipamentos', 'e')
                ->where('e.id = ?1')
                ->setParameter(1, $id);

        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    function listagem() {
        require ROOT . "config/bootstrap.php";
        $t = $em->getRepository('models\Equipamentos');
        $qb = $t->createQueryBuilder('e');
        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

}
