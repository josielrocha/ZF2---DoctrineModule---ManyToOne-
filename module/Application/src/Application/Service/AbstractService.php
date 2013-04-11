<?php

namespace Application\Service;

use Zend\Form\FormInterface;
use Zend\Paginator\Paginator;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;

abstract class AbstractService implements ServiceManagerAwareInterface
{
    /**
     * @var \DoctrineORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var type
     */
    protected $paginator;

    /**
     * @var boolean
     */
    protected $usePaginator;

    /**
     * @var array
     */
    protected $paginatorOptions;

    public function save($data, FormInterface $form = null, $entity = null)
    {
        if (is_scalar($entity)) {
            $entity = $this->findById($entity);
        }

        if (!$form) {
            $form = $this->getForm();
        }

        if (is_object($entity)) {
            $form->bind($entity);
        }
        $form->setData($data);

        if ($form->isValid()) {
            $entity = $form->getData();

            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();

            return $entity;
        }

        return false;
    }

    public function delete($entity)
    {
        if (is_scalar($entity)) {
            $entity = $this->findById($entity);
        }
        if (!is_object($entity)) {
            throw new \InvalidArgumentException('$entity de ser um objeto, foi passado um ' . gettype($entity));
        }

        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
        return;
    }

    public function getEntityManager()
    {
        if (!$this->entityManager) {
            $this->entityManager = $this->getServiceManager()->get('Doctrine\ORM\EntityManager');
        }
        return $this->entityManager;
    }

    abstract protected function getRepository();

    public function getForm($fqcn = null)
    {
        if (null === $fqcn) {
            $fqcn = $this->fqcn;
        }
        return $this->getServiceManager()->get('FormElementManager')->get($fqcn);
    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    public function usePaginator(array $options = array())
    {
        $this->setUsePaginator(true);
        $this->paginatorOptions = $options;
        return $this;
    }

    public function initPaginator()
    {
        $adapter = new DoctrineAdapter(new ORMPaginator($this->getRepository()->getNewQueryBuilder()));
        $paginator = new Paginator($adapter);

        $options = $this->getPaginatorOptions();
        if (isset($options['n'])) {
            $paginator->setItemCountPerPage($options['n']);
        }
        if (isset($options['p'])) {
            $paginator->setCurrentPageNumber($options['p']);
        }

        return $paginator;
    }

    public function getUsePaginator()
    {
        return $this->usePaginator;
    }

    public function setUsePaginator($value = true)
    {
        $this->usePaginator = (bool) $value;
        return $this;
    }

    public function getPaginatorOptions()
    {
        return $this->paginatorOptions;
    }

    public function setPaginatorOptions(array $paginatorOptions)
    {
        $this->paginatorOptions = $paginatorOptions;
        return $this;
    }

    public function findAll()
    {
        if ($this->getUsePaginator()) {
            return $this->initPaginator();
        }

        return $this->getRepository()->findAll();
    }

    public function find(array $data)
    {
        return $this->getRepository()->find($data);
    }

    public function findById($id)
    {
        return $this->getRepository()->getById($id);
    }
}
