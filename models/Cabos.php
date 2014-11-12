<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Util\Debug;

/**
 * Cabos
 *
 * @ORM\Table(name="cabos", indexes={@ORM\Index(name="fk_cabos_usuarios1_idx", columns={"usuarios_id"}), @ORM\Index(name="fk_cabos_equipamentos1_idx", columns={"equipamentos_id"}), @ORM\Index(name="fk_cabos_patchpanel1_idx", columns={"patchpanel_id"})})
 * @ORM\Entity
 */
class Cabos {

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
     * @ORM\Column(name="cor", type="string", length=45, nullable=true)
     */
    private $cor;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=45, nullable=true)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=45, nullable=true)
     */
    private $descricao;

    /**
     * @var integer
     *
     * @ORM\Column(name="codigo", type="integer", nullable=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="equipamentos_porta", type="string", length=45, nullable=false)
     */
    private $equipamentosPorta;

    /**
     * @var string
     *
     * @ORM\Column(name="patchpanel_porta", type="string", length=45, nullable=false)
     */
    private $patchpanelPorta;

    /**
     * @var \Usuarios
     *
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuarios_id", referencedColumnName="id")
     * })
     */
    private $usuarios;

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

    public function getId() {
        return $this->id;
    }

    public function getCor() {
        return $this->cor;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getEquipamentosPorta() {
        return $this->equipamentosPorta;
    }

    public function getPatchpanelPorta() {
        return $this->patchpanelPorta;
    }

    public function getUsuarios() {
        return $this->usuarios;
    }

    public function getEquipamentos() {
        return $this->equipamentos;
    }

    public function getPatchpanel() {
        return $this->patchpanel;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCor($cor) {
        $this->cor = $cor;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setEquipamentosPorta($equipamentosPorta) {
        $this->equipamentosPorta = $equipamentosPorta;
    }

    public function setPatchpanelPorta($patchpanelPorta) {
        $this->patchpanelPorta = $patchpanelPorta;
    }

    public function setUsuarios(Usuarios $usuarios) {
        $this->usuarios = $usuarios;
    }

    public function setEquipamentos(Equipamentos $equipamentos) {
        $this->equipamentos = $equipamentos;
    }

    public function setPatchpanel(Patchpanel $patchpanel) {
        $this->patchpanel = $patchpanel;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    /*
     * Metodo Insert
     * Responsavel pela inserção dos dados
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     * 
     */

    public function Insert($objecto, $equipamento, $patchpanel) {
        require ROOT . "config/bootstrap.php";
        $equipamento = $em->getRepository('models\Equipamentos')->findOneBy(array('id' => $equipamento));
        $path = $em->getRepository('models\Patchpanel')->findOneBy(array('id' => $patchpanel));
        $usuario = $em->getRepository('models\Usuarios')->findOneBy(array('id' => \application\Session::get('id')));
        $objecto->setEquipamentos($equipamento);
        $objecto->setPatchpanel($path);
        $objecto->setUsuarios($usuario);
        $em->persist($objecto);
        $em->flush();
        return $objecto->getId();
    }

    /*
     * Metodo listarAll
     * Responsavel pela listagem de todos os  dados
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function listaAll() {
        require ROOT . "config/bootstrap.php";
        return $em->getRepository('models\Cabos')->findby(array(), array("id" => "DESC"));
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

    /*
     * Metodo Delete
     * Responsavel pela remoção de dados no banco onde o id é passado por parametro
     * @db->variavel que contem o meu arquivo bootstrap do doctrine
     */

    function Delete($id) {
        require ROOT . "config/bootstrap.php";
        $excluir = $em->getPartialReference('models\Equipamentos', $id);
        $em->remove($excluir);
        $em->flush();
    }

    function pesquisaId($id = NULL) {
        require ROOT . "config/bootstrap.php";
        $t = $em->getRepository('models\Cabos');
        $qb = $em->createQueryBuilder()
                ->select('e.id')
                ->from('models\Cabos', 'e')
                ->where('e.codigo = ?1')
                ->setParameter(1, $id);

        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

}
