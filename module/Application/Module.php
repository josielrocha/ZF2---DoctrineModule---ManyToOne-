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
                }
            ),
        );
    }
}
