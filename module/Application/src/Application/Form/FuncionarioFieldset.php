<?php

namespace Application\Form;

use Zend\Form\Fieldset;

class FuncionarioFieldset extends Fieldset
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function __construct($name = 'funcionario')
    {
        parent::__construct($name);
    }

    public function init()
    {
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'nome',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Nome',
            ),
        ));

        $this->add(array(
            'name' => 'ocupacao',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Ocupação',
                'object_manager' => $this->getEntityManager(),
                'target_class' => 'Application\Entity\Ocupacao',
            ),
        ));
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }
}
