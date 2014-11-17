<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Util\Debug;

/**
 * Propriedade
 *
 * @ORM\Table(name="propriedade", indexes={@ORM\Index(name="fk_propriedade_equipamentos1_idx", columns={"equipamentos_id"}), @ORM\Index(name="fk_propriedade_patchpanel1_idx", columns={"patchpanel_id"})})
 * @ORM\Entity
 */
class Propriedade {

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
     * @ORM\Column(name="valor", type="string", length=45, nullable=true)
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="chave", type="string", length=45, nullable=true)
     */
    private $chave;

    /**
     * @var \Equipamentos
     *
     * @ORM\ManyToOne(targetEntity="Equipamentos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipamentos_id", referencedColumnName="id")
     * })
     */
    private $equipamentos;

    

    public function getId() {
        return $this->id;
    }

    public function getValor() {
        return $this->valor;
    }

    public function getChave() {
        return $this->chave;
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

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function setChave($chave) {
        $this->chave = $chave;
    }

    public function setEquipamentos(Equipamentos $equipamentos) {
        $this->equipamentos = $equipamentos;
    }

    public function setPatchpanel(Patchpanel $patchpanel) {
        $this->patchpanel = $patchpanel;
    }

    public function Insert($objecto, $equipamento) {
        require ROOT . "config/bootstrap.php";
        $equip = $em->getRepository('models\Equipamentos')->find($equipamento);
        $objecto->setEquipamentos($equip);
        $em->persist($objecto);
        $em->flush();
    }

}
