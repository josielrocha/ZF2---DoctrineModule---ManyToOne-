<?php

namespace Application\Form;

use Zend\Form\Fieldset;

class CampusFieldset extends Fieldset
{
    public function __construct($name = 'campus')
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
            'name' => 'contatos',
            'type' => 'Zend\Form\Element\Collection',
            'options' => array(
                'should_create_template' => true, // Caso você queira que o form tenha o atributo data-template, para que você possa clonar o elemento quer ficará dentro do Collection
                'allow_add' => true, // Caso você queira que o Collection permita adição de elementos
                'count' => 2, // Quantidade inicial de elementos no Collection

                'target_element' => array(
                    'name' => 'contato',
                    'type' => 'Application\Form\ContatoFieldset',
                    'options' => array(
                        'label' => 'Contato',
                    ),
                ), // Elemento que irá compor o Collection

                'label' => 'Contatos',
            ),
        ));
    }
}
