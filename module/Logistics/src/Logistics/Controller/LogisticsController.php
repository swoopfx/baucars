<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Logistics for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 *
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
use Laminas\Json\Json;
use Logistics\Service\LogisticsService;
use JWT\Service\ApiAuthenticationService;
use Logistics\Entity\LogisticsRequest;
use Logistics\Entity\LogisticsBikeRiders;

class LogisticsController extends AbstractActionController
{

    private $generalService;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var LogisticsService
     */
    private $logisticsService;

    /**
     *
     * @var ApiAuthenticationService
     */
    private $apiAuthService;

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
     * security={{"bearerAuth":{}}}
     * )
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function deliveryTypeAction()
    {
        try {

            $this->apiAuthService->getIdentity();
            $jsonModel = new JsonModel();
            $em = $this->entityManager;
            $repo = $em->getRepository(LogisticsDeliveryType::class);

            $data = $repo->createQueryBuilder("l")
                ->select("l")
                ->getQuery()
                ->setHydrationMode(Query::HYDRATE_ARRAY)
                ->getArrayResult();

            $jsonModel->setVariables(array(
                "data" => $data
            ));
            return $jsonModel;
        } catch (\Exception $e) {
            return Json::encode($e->getMessage());
        }
    }

    /**
     * @OA\GET( path="/logistics/logistics/payment-mode", tags={"Logistics"},
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="403", description="Error"),
     * security={{"bearerAuth":{}}}
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

        $jsonModel->setVariables(array(
            "data" => $data
        ));
        return $jsonModel;
    }

    /**
     * @OA\GET( path="/logistics/logistics/service-type", tags={"Logistics"},
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="403", description="Error"),
     * security={{"bearerAuth":{}}}
     * )
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function serviceTypeAction()
    {
        try {
            // var_dump("KIIY");
            $jsonModel = new JsonModel();
            $em = $this->entityManager;
            $repo = $em->getRepository(LogisticsServiceType::class);

            $data = $repo->createQueryBuilder("l")
                ->select("l")
                ->getQuery()
                ->setHydrationMode(Query::HYDRATE_ARRAY)
                ->getArrayResult();

            $jsonModel->setVariables(array(
                "data" => $data
            ));
            return $jsonModel;
        } catch (\Exception $e) {
        }
    }

    /**
     *
     *
     *
     * @OA\POST( path="/logistics/logistics/calculate-stats", tags={"Logistics"}, description="Used to get Statistics inforamtion about the package about to be delivered this information is only required to be displayed only, once this is successfully acquired, a call to flutterwave payment gateway should be made, the",
     *
     * @OA\RequestBody(
     * @OA\MediaType(
     * mediaType="application/json",
     * @OA\Schema(required={"destinationPlaceId", "pickUpPlaceId", "destinationAddress", "pickAddress", "pickupLong", "pickupLat", "destinationLat", "destinationLong", "quantity", "iten_name"},
     * @OA\Property(property="destinationPlaceId", type="string", example="EjFJbnQnbCBBaXJwb3J0IFJkLCBNYWZvbHVrdSBPc2hvZGksIExhZ29zLCBOaWdlcmlhIi4qLAoUChIJjagx-h6OOxARwyZNkX_GTysSFAoSCZk5KvookjsQEfChu91LMqjX", description="Google Place id (Unique) of the Destination"),
     * @OA\Property(property="pickUpPlaceId", type="string", example="ChIJS9Q72lL0OxARKJ3cGrQfM0c", description="Google Place id (Unique) of the pickup"),
     * @OA\Property(property="pickAddress", type="string", example="Kola Oyewo street surulere, lagos Nigeria", description="Pick up Address"),
     * @OA\Property(property="destinationAddress", type="string", example="Fatai Abduwahid street Ijegun, lagos Nigeria", description="Destination Address"),
     * @OA\Property(property="pickupLat", type="string", example="3.4723495", description="The latitude of the pickup address"),
     * @OA\Property(property="pickupLong", type="string", example="3.4723495", description="The longitude of the pickup address"),
     * @OA\Property(property="destinationLat", type="string", example="3.4723495", description="The latitude of the destination address "),
     * @OA\Property(property="destinationLong", type="string", example="3.4723495", description="The longitude of the destination address "),
     * @OA\Property(property="quantity", type="integer", example=2, description="The qauntity of the item"),
     * @OA\Property(property="iten_name", type="string", example="Bag of oranges", description="Identifier description of tha package"),
     * @OA\Property(property="service_type", type="integer", example=10, description="This is an id referenced from the logistics/logistics/service-type url"),
     * @OA\Property(property="delivery_type", type="integer", example=10, description="This is an id referenced from the logistics/logistics/delivery-type url"),
     * @OA\Property(property="note", type="string", example="I want this package delivered before 10am ", description="Additional information for the package"),
     *
     * )
     * ),
     * ),
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="401", description="Not Authorized"),
     * @OA\Response(response="403", description="Not permitted"),
     *
     * security={{"bearerAuth":{}}}
     *
     * )
     *
     * requires
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function calculateStatsAction()
    {
        try {
            // $this->apiAuthService->getIdentity();
            $jsonModel = new JsonModel();
            $request = $this->getRequest();
            $response = $this->getResponse();
            $response->setStatusCode(400);
            if ($request->isPost()) {
                try {
                    $post = Json::decode(file_get_contents("php://input"));

                    $data = $this->logisticsService->priceandDistanceCalculator(get_object_vars($post));
                    $response->setStatusCode(200);
                    $jsonModel->setVariables([
                        "data" => $data
                    ]);
                } catch (\Exception $e) {
                    $response->setStatusCode(401);

                    $jsonModel->setVariables([
                        "error" => $e->getMessage()
                    ]);
                }
            } else {
                $jsonModel->setVariables([
                    "message" => "Not Authorized"
                ]);
            }
        } catch (\Exception $e) {
            return Json::encode($e->getMessage());
        }

        return $jsonModel;
    }

    /**
     *
     *
     *
     * @OA\POST( path="/logistics/logistics/create-request", tags={"Logistics"}, description="Used to create a request of service ",
     *
     * @OA\RequestBody(
     * @OA\MediaType(
     * mediaType="application/json",
     * @OA\Schema(required={"destinationPlaceId", "pickUpPlaceId", "destinationAddress", "pickAddress"},
     * @OA\Property(property="destinationPlaceId", type="string", example="EjFJbnQnbCBBaXJwb3J0IFJkLCBNYWZvbHVrdSBPc2hvZGksIExhZ29zLCBOaWdlcmlhIi4qLAoUChIJjagx-h6OOxARwyZNkX_GTysSFAoSCZk5KvookjsQEfChu91LMqjX", description="Google Place id (Unique) of the Destination"),
     * @OA\Property(property="pickUpPlaceId", type="string", example="ChIJS9Q72lL0OxARKJ3cGrQfM0c", description="Google Place id (Unique) of the pickup"),
     * @OA\Property(property="pickAddress", type="string", example="Kola Oyewo street surulere, lagos Nigeria", description="Pick up Address"),
     * @OA\Property(property="destinationAddress", type="string", example="Fatai Abduwahid street Ijegun, lagos Nigeria", description="Destination Address"),
     * @OA\Property(property="pickupLat", type="string", example="3.4723495", description="The latitude of the pickup address"),
     * @OA\Property(property="pickupLong", type="string", example="3.4723495", description="The longitude of the pickup address"),
     * @OA\Property(property="destinationLat", type="string", example="3.4723495", description="The latitude of the destination address "),
     * @OA\Property(property="destinationLong", type="string", example="3.4723495", description="The longitude of the destination address "),
     * @OA\Property(property="quantity", type="integer", example=2, description="The qauntity of the item"),
     * @OA\Property(property="iten_name", type="string", example="Bag of oranges", description="Identifier description of tha package"),
     *
     * @OA\Property(property="txRef", type="string", example="inv61706f10b762a", description="This is transaction unique identifier generated from the calculate-stats url must always be attached be it wallet or card payment"),
     * @OA\Property(property="status", type="string", example="success", description="This could either be success or error if the response code is 400 according to flutterwave "),
     * @OA\Property(property="service_type", type="integer", example=10, description="This is an id referenced from the logistics/logistics/service-type url"),
     * @OA\Property(property="payment_mode", type="integer", example=20, description="This is an id referenced from the logistics/logistics/payment-mode url"),
     * @OA\Property(property="delivery_type", type="integer", example=10, description="This is an id referenced from the logistics/logistics/delivery-type url"),
     * @OA\Property(property="note", type="string", example="I want this package delivered before 10am ", description="Additional information for the package"),
     * )
     * ),
     * ),
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="401", description="Not Authorized"),
     * @OA\Response(response="403", description="Not permitted"),
     *
     * security={{"bearerAuth":{}}}
     *
     * )
     *
     * requires
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function createRequestAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $response->setStatusCode(400);
        if ($request->isPost()) {
            try {
                $post = Json::decode(file_get_contents("php://input"));
                $data = $this->logisticsService->createRequest(get_object_vars($post));
                $response->setStatusCode(201);
                $jsonModel->setVariables(array(
                    "data" => $data
                ));
            } catch (\Exception $e) {
                $jsonModel->setVariables([
                    "message" => "Not Authorized"
                ]);
            }
        }
        return $jsonModel;
    }

    /**
     * @OA\GET( path="/logistics/logistics/requests", tags={"Logistics"}, description="This Get a list of all active Logistics request",
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="403", description="Error"),
     * security={{"bearerAuth":{}}}
     * )
     * Gets a list of all active request associated to this user
     * @return JsonModel
     */
    public function requestsAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $repo = $em->getRepository(LogisticsRequest::class);
        $data = $repo->createQueryBuilder("s")->select(array(
            "s"
        ))
            ->where("s.isActive = :active")
            ->setParameters(array(
                "active" => true,
            ))
            ->getQuery()
            ->setHydrationMode(Query::HYDRATE_ARRAY)
            ->getArrayResult();
        $jsonModel->setVariables(array(
            "data" => $data
        ));
        return $jsonModel;
    }

    /**
     * @OA\GET( path="/logistics/logistics/riderinfo/{uid}", tags={"RIDER"}, description="This Gets a riders information usually associated to an active ride",
     *  @OA\Parameter(in="path", name="uid"),
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="403", description="Error"),
     * security={{"bearerAuth":{}}}
     *     )
     * Gets a riders information usually associated to an active ride
     * @return JsonModel
     */
    public function riderinfoAction()
    {
        try {
//            var_dump("LOO");
            $this->apiAuthService->getIdentity();
            $jsonModel = new JsonModel();
            $em = $this->entityManager;

            $response = $this->getResponse();
            $uid = $this->params()->fromRoute("uid", null);
            var_dump($uid);
            if ($uid != null) {
                $repo = $em->getRepository(LogisticsBikeRiders::class);
                $data = $repo->createQueryBuilder('s')
                    ->select(array("s", "u"))
                    ->leftJoin("s.user", "u")
                    ->where("s.riderUid = :uid")
                    ->setParameters(array(
                        "uid" => $uid
                    ))->getQuery()
                    ->setHydrationMode(Query::HYDRATE_ARRAY)
                    ->getArrayResult();

                $jsonModel->setVariables(array(
                    "data"=>$data
                ));
            } else {
                $response->setStatusCode(400);
                $jsonModel->setVariables(array(
                    "message" => "Absent Identifier"
                ));

            }
        }catch (\Exception $e){
            return Json::encode($e->getMessage());
        }

        return $jsonModel;
    }


    /**
     * * @OA\GET( path="/logistics/logistics/rideinfo", tags={"Logistics"}, description="This gets an information for an active ride",
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="403", description="Error"),
     * security={{"bearerAuth":{}}}
     *     )
     *
     * gets an information for an active ride
     * @return JsonModel
     */
    public function rideinfoAction()
    {
        $jsonModel = new JsonModel();

        return $jsonModel;
    }

//    public function

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
     * @param field_type $generalService
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
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
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     *
     * @return the $logisticsService
     */
    public function getLogisticsService()
    {
        return $this->logisticsService;
    }

    /**
     *
     * @param \Logistics\Service\LogisticsService $logisticsService
     */
    public function setLogisticsService($logisticsService)
    {
        $this->logisticsService = $logisticsService;
        return $this;
    }

    /**
     *
     * @return the $apiAuthService
     */
    public function getApiAuthService()
    {
        return $this->apiAuthService;
    }

    /**
     *
     * @param \JWT\Service\ApiAuthenticationService $apiAuthService
     */
    public function setApiAuthService($apiAuthService)
    {
        $this->apiAuthService = $apiAuthService;
        return $this;
    }
}
