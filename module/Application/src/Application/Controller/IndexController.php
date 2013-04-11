<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $page = $this->params()->fromRoute('page', null);
        if (!$page) {
            return $this->redirect()->toRoute('application/pagination');
        }

        return new ViewModel(array(
            'itens'  => $this->getService()->usePaginator()->findAll(),
            'params' => $this->params()->fromRoute(),
        ));
    }

    public function addAction()
    {
        $form = $this->getServiceLocator()->get('FormElementManager')->get('Application\Form\Campus');

        $view = new ViewModel(array(
            'form' => $form,
        ));

        $prg = $this->prg($this->getRequest()->getRequestUri(), true);

        if ($prg instanceof Response) {
            return $prg;
        } elseif (false === $prg) {
            return $view;
        }

        $post = $prg;

        $service = $this->getService();
        $entity = $service->save($post, $form);

        $messenger = $this->getFlashMessenger();

        if (!$entity) {
            $view->setVariable('status', false);
            return $view;
        }

        $messenger->addMessage('Adição efetuada com sucesso.');
        return $this->redirect()->toRoute('application');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', $this->params()->fromPost('id', 0));
        $messenger = $this->getFlashMessenger();

        if (!$id) {
            $messenger->addMessage('Id inválido.');
            return $this->redirect()->toRoute('application');
        }

        $service = $this->getService();
        if (!($entity = $service->findById($id))) {
            $messenger->addMessage('Id inválido.');
            return $this->redirect()->toRoute('application');
        }

        $form = $this->getServiceLocator()->get('FormElementManager')->get('Application\Form\Campus');
        $form->bind($entity);

        $view = new ViewModel(array(
            'form' => $form,
            'id'   => $id,
        ));

        $prg = $this->prg($this->getRequest()->getRequestUri(), true);
        if ($prg instanceof Response) {
            return $prg;
        } else if (false === $prg) {
            return $view;
        }

        $post = $prg;
        $form->setData($post);

        $result = $service->save($post, $form, $entity);
        if ($result) {
            $messenger->addMessage('Alterações efetuadas com sucesso.');
            return $this->redirect()->toRoute('application');
        }

        $view->setVariable('status', false);
        $messenger->addMessage('Verifique os dados informados e tente novamente.');
        return $view;
    }

    public function viewAction()
    {
        $id = (int) $this->params()->fromRoute('id', $this->params()->fromPost('id', 0));
        $messenger = $this->getFlashMessenger();

        if (!$id) {
            $messenger->addMessage('Id inválido.');
            return $this->redirect()->toRoute('application');
        }

        $service = $this->getService();
        if (!($entity = $service->findById($id))) {
            $messenger->addMessage('Id inválido.');
            return $this->redirect()->toRoute('application');
        }

        $viewModel = new ViewModel(array(
            'campus' => $entity,
        ));

        return $viewModel;
    }

    public function delAction()
    {
        $id = (int) $this->params()->fromRoute('id', $this->params()->fromPost('id', 0));
        $messenger = $this->getFlashMessenger();

        if (!$id) {
            $messenger->addMessage('Id inválido');
            return $this->redirect()->toRoute('application');
        }

        $entity = $this->getService()->findById($id);
        if (!$entity) {
            $messenger->addMessage('Id inválido');
            return $this->redirect()->toRoute('application');
        }

        if ($this->getRequest()->isPost()) {
            if ($this->params()->fromPost('del') == 'Sim') {
                if ($this->getService()->delete($entity)) {
                    $messenger->addMessage('Exclusão efetuada com sucesso.');
                } else {
                    $messenger->addMessage('Não foi possível efetuar a exclusão');
                }
            } else {
                $messenger->addMessage('Exclusão não efetuada.');
            }

            return $this->redirect()->toRoute('application');
        }
        $view = new ViewModel(array(
            'entity' => $entity,
            'uri'    => $this->getRequest()->getRequestUri(),
        ));

        return $view;
    }

    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

    public function getFlashMessenger()
    {
        $messenger = $this->flashMessenger()->setNamespace('application');
        return $messenger;
    }

    public function getService()
    {
        return $this->getServiceLocator()->get('Application\Service\Campus');
    }
}
