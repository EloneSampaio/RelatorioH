<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Destino
 *
 * @ORM\Table(name="destino", indexes={@ORM\Index(name="fk_cabos_usuarios1_idx", columns={"usuarios_id"}), @ORM\Index(name="fk_cabos_equipamentos1_idx", columns={"equipamentos_id"}), @ORM\Index(name="fk_cabos_patchpanel1_idx", columns={"patchpanel_id"}), @ORM\Index(name="fk_destino_cabos1_idx", columns={"cabos_id"})})
 * @ORM\Entity
 */
class Destino {

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
     * @var integer
     *
     * @ORM\Column(name="codigo", type="integer", nullable=false)
     */
    private $codigo;

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

    /**
     * @var \Cabos
     *
     * @ORM\ManyToOne(targetEntity="Cabos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cabos_id", referencedColumnName="id")
     * })
     */
    private $cabos;

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

    public function getCodigo() {
        return $this->codigo;
    }

    public function getEquipamentos() {
        return $this->equipamentos;
    }

    public function getPatchpanel() {
        return $this->patchpanel;
    }

    public function getUsuarios() {
        return $this->usuarios;
    }

    public function getCabos() {
        return $this->cabos;
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

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setEquipamentos(Equipamentos $equipamentos) {
        $this->equipamentos = $equipamentos;
    }

    public function setPatchpanel(Patchpanel $patchpanel) {
        $this->patchpanel = $patchpanel;
    }

    public function setUsuarios(Usuarios $usuarios) {
        $this->usuarios = $usuarios;
    }

    public function setCabos(Cabos $cabos) {
        $this->cabos = $cabos;
    }

    public function Insert($objecto, $equipamento, $patchpanel, $cabo) {
        require ROOT . "config/bootstrap.php";
        $equipamento = $em->getRepository('models\Equipamentos')->findOneBy(array('id' => $equipamento));
        $path = $em->getRepository('models\Patchpanel')->findOneBy(array('id' => $patchpanel));
        $cabo = $em->getRepository('models\Cabos')->findOneBy(array('id' => $cabo));
        $usuario = $em->getRepository('models\Usuarios')->findOneBy(array('id' => \application\Session::get('id')));
        $objecto->setEquipamentos($equipamento);
        $objecto->setPatchpanel($path);
        $objecto->setCabos($cabo);
        $objecto->setUsuarios($usuario);
        $em->persist($objecto);
        $em->flush();
        return TRUE;
    }

    function listaAll() {
        require ROOT . "config/bootstrap.php";
        return $em->getRepository('models\Destino')->findby(array(), array("id" => "DESC"));
        $em->flush();
    }

    function listagem($id) {
        require ROOT . "config/bootstrap.php";
        $t = $em->getRepository('models\Cabos');
        $qb = $em->createQueryBuilder();

        $qb->select(array('a', 'c', 'e', 'e1', 'p', 'p1', 'r', 'r1'))
                ->from('models\Destino', 'a')
                ->innerJoin('a.cabos', 'c')
                ->innerJoin('a.equipamentos', 'e')
                ->innerJoin('c.equipamentos', 'e1')
                ->innerJoin('a.patchpanel', 'p')
                ->innerJoin('c.patchpanel', 'p1')
                ->innerJoin('e.racks', 'r')
                ->innerJoin('e1.racks', 'r1')
                ->where('a.cabos = ?1')
                ->setParameter(1, $id);
        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

}
