<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_contatos")
 */
class Contato
{
    /**
     * @var int
     * @access protected
     *
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_contato")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @access protected
     *
     * @ORM\Column(type="string", length=40, nullable=false)
     */
    protected $nome;

    public function getId() {
        return $this->id;
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
}
