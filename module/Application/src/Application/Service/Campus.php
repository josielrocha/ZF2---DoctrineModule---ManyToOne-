<?php

namespace Application\Service;

class Campus extends AbstractService
{
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('Application\Entity\Campus');
    }
}
