<?php

namespace Application\Form;

use Zend\Form\Fieldset;

class ContatoFieldset extends Fieldset
{
    public function __construct($name = 'contato')
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
    }
}
