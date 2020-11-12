<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use CsnUser\Service\UserService;

class IndexController extends AbstractActionController
{

    public function dashboardAction()
    {
        $uri = $this->getRequest()->getUri();
        $baseUrl = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        return $this->redirect()->toUrl($baseUrl . "/" . UserService::routeManager($this->identity()));
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function aboutAction()
    {
        return new ViewModel();
    }

    public function servicesAction()
    {
        return new ViewModel();
    }

    public function carsAction()
    {
        return new ViewModel();
    }

    public function contactAction()
    {
        return new ViewModel();
    }
}
