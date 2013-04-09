<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_campus")
 */
class Campus
{
    /**
     * @var integer
     * @access protected
     *
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_campus")
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

    /**
     * @var Contato[]
     * @access protected
     *
     * @ORM\ManyToMany(targetEntity="Application\Entity\Contato", cascade={"persist", "remove"})
     * @ORM\JoinTable(
     *  name="campus_contato",
     *  joinColumns={@ORM\JoinColumn(referencedColumnName="id_campus", name="id_campus")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="id_contato", referencedColumnName="id_contato")}
     * )
     */
    protected $contatos;

    public function __construct()
    {
        $this->contatos = new \Doctrine\Common\Collections\ArrayCollection();
    }

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

    public function getContatos() {
        return $this->contatos;
    }

    public function addContato(Contato $contato)
    {
        $this->contatos->add($contato);
        return $this;
    }

    public function removeContato($contato)
    {
        $this->contatos->removeElement($contato);
        return $this;
    }

    public function addContatos($contatos)
    {
        foreach ($contatos as $contato) {
            $this->addContato($contato);
        }
        return $this;
    }

    public function removeContatos($contatos)
    {
        foreach ($contatos as $contato) {
            $this->removeContato($contato);
        }
        return $this;
    }
}
