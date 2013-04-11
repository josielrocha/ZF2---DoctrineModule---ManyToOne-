<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\FormElementProviderInterface;

class Module implements FormElementProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        ini_set('display_errors', true);
        date_default_timezone_set('America/Sao_Paulo');
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
                'Application\Form\ContatoFieldset' => function($sm) {
                    $serviceLocator = $sm->getServiceLocator();
                    $entityManager  = $serviceLocator->get('Doctrine\ORM\EntityManager');
                    $hydrator       = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($entityManager, 'Application\Entity\Contato');
                    $fieldset = new Form\ContatoFieldset();
                    $fieldset
                        ->setObject(new Entity\Contato())
                        ->setHydrator($hydrator);

                    return $fieldset;
                },
                'Application\Form\CampusFieldset' => function($sm) {
                    $serviceLocator = $sm->getServiceLocator();
                    $entityManager  = $serviceLocator->get('Doctrine\ORM\EntityManager');
                    $hydrator       = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($entityManager, 'Application\Entity\Campus');
                    $fieldset = new Form\CampusFieldset();
                    $fieldset
                        ->setObject(new Entity\Campus())
                        ->setHydrator($hydrator);

                    return $fieldset;
                },
                'Application\Form\FuncionarioFieldset' => function($sm) {
                    $serviceLocator = $sm->getServiceLocator();
                    $entityManager  = $serviceLocator->get('Doctrine\ORM\EntityManager');
                    $hydrator       = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($entityManager, 'Application\Entity\Funcionario');
                    $fieldset = new Form\FuncionarioFieldset();
                    $fieldset
                        ->setEntityManager($entityManager)
                        ->setObject(new Entity\Funcionario())
                        ->setHydrator($hydrator);

                    return $fieldset;
                },
            ),
        );
    }
}
