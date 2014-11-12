<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Grupo
 *
 * @ORM\Table(name="grupo")
 * @ORM\Entity
 */
class Grupo {

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
     * @ORM\Column(name="nivel", type="string", nullable=false)
     */
    private $nivel;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=45, nullable=true)
     */
    private $descricao;

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getNivel() {
        return $this->nivel;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

}
