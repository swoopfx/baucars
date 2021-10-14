<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Logistics for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * 
 * @OA\Info(title="APi Authentication ", version="1.0")
 * 
 */
namespace Logistics\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;
use Logistics\Entity\LogisticsDeliveryType;
use Doctrine\ORM\Query;
use Logistics\Entity\LogisticsPaymentMode;
use Logistics\Entity\LogisticsServiceType;
use function GuzzleHttp\json_decode;
use Laminas\Json\Json;

class LogisticsController extends AbstractActionController
{

    private $generalService;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    public function indexAction()
    {
        return array();
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /logistics/logistics/foo
        return array();
    }

    // public function boardAction
    
    // public function active
    
    /**
     * @OA\GET( path="/logistics/logistics/delivery-type", tags={"Logistics"},
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="403", description="Error"),
     * )
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function deliveryTypeAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $repo = $em->getRepository(LogisticsDeliveryType::class);
        
        $data = $repo->createQueryBuilder("l")
            ->select("l")
            ->getQuery()
            ->setHydrationMode(Query::HYDRATE_ARRAY)
            ->getArrayResult();
        
        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    /**
     * @OA\GET( path="/logistics/logistics/payment-mode", tags={"Logistics"},
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="403", description="Error"),
     * )
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function paymentModeAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $repo = $em->getRepository(LogisticsPaymentMode::class);
        
        $data = $repo->createQueryBuilder("l")
        ->select("l")
        ->getQuery()
        ->setHydrationMode(Query::HYDRATE_ARRAY)
        ->getArrayResult();
        
        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    /**
     * @OA\GET( path="/logistics/logistics/service-type", tags={"Logistics"},
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="403", description="Error"),
     * )
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function serviceTypeAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $repo = $em->getRepository(LogisticsServiceType::class);
        
        $data = $repo->createQueryBuilder("l")
        ->select("l")
        ->getQuery()
        ->setHydrationMode(Query::HYDRATE_ARRAY)
        ->getArrayResult();
        
        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    public function logisticsRequestAction()
    {
        // $jsonModel = new
    }
    
    public function calculateStatsAction(){
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $response->setStatusCode(400);
        if($request->isPost()){
            $post = Json::decode(file_get_contents("php://input"));
            
        }else{
            $jsonModel->setVariables([
                "message"=>"Not Authorized"
            ]);
        }
        return $jsonModel;
    }

    /**
     *
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     *
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     *
     * @param field_type $generalService            
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

    /**
     *
     * @param \Doctrine\ORM\EntityManager $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }
}
