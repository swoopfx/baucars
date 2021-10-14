<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Wallet for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Wallet\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use General\Service\GeneralService;
use Doctrine\ORM\EntityManager;
use Wallet\Entity\Wallet;

class WalletController extends AbstractActionController
{
    
    /**
     * 
     * @var GeneralService
     */
    private $generalService;
    
    
    public function indexAction(){
        /**
         * 
         * @var EntityManager $em
         */
        $user = $this->identity();
        $em = $this->generalService->getEntityManager();
        $jsonModel = new JsonModel();
        $repo = $em->getRepository(Wallet::class)->findOneBy([
            "user"=> $user->getId(),
        ]);
        return $jsonModel;
    }
}
