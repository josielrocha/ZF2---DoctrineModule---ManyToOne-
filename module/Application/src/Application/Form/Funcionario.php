<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class Funcionario extends Form implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;

    public function __construct($name = 'funcionario')
    {
        parent::__construct($name);
        $this->setObject(new \Application\Entity\Funcionario());
    }

    public function init()
    {
        $this->add(array(
            'type' => 'Application\Form\FuncionarioFieldset',
            'name' => 'funcionario',
            'options' => array(
                'use_as_base_fieldset' => true,
            ),
        ));

        $this->add(array(
            'name'=> 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Enviar',
            ),
        ));
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

}
