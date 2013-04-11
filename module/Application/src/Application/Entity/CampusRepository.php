<?php

namespace Application\Entity;

use Doctrine\ORM\EntityRepository;

class CampusRepository extends EntityRepository
{
    public function getById($id)
    {
        $query = $this->getNewQueryBuilder();
        $query
            ->where('c.id = :id')
           ->setParameter('id', $id);

        $action = $query->getQuery()->getOneOrNullResult();

        return $action;
    }

    public function getNewQueryBuilder()
    {
        $query = $this->_em->createQueryBuilder();
        $query
            ->select('c')
            ->from('Application\Entity\Campus', 'c');

        return $query;
    }
}
