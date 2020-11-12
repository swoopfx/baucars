<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Application\Entity\Cars;
use Doctrine\ORM\Query;
use General\Entity\MotorMake;
use Zend\InputFilter\InputFilter;
use Driver\Entity\DriverBio;
use CsnUser\Entity\User;
use CsnUser\Entity\Role;
use CsnUser\Service\UserService;
use CsnUser\Entity\State;
use Driver\Paginator\DriverAdapter;
use Driver\Service\DriverService;

/**
 *
 * @author otaba
 *        
 */
class DriverController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var DriverAdapter
     */
    private $driverPaginator;

    // private
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function driversAction()
    {
        $viewModel = new ViewModel([
            "drivers" => $this->driverPaginator
        ]);
        return $viewModel;
    }

    public function allcarsmakeAction()
    {
        $em = $this->entityManager;
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $repo = $em->getRepository(MotorMake::class);
        $result = $repo->createQueryBuilder("c")
            ->select("c")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        
        $jsonModel->setVariable("data", $result);
        $response->setStatusCode(200);
        return $jsonModel;
    }

    public function createdriverAction()
    {
        $em = $this->entityManager;
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            
            $inputFilter = new InputFilter();
            
            $inputFilter->add(array(
                'name' => 'fullname',
                'required' => true,
                'allow_empty' => false,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Driver Full name is required'
                            )
                        )
                    )
                )
            ));
            
            $inputFilter->add(array(
                'name' => 'phoneNumber',
                'required' => true,
                'allow_empty' => false,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Phone Number is required'
                            )
                        )
                    )
                )
            ));
            
            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                try {
                    
                    $data = $inputFilter->getValues();
                    $phoneStipped = str_replace("-", "", $data["phoneNumber"]);
                    $email = $post["email"] == "" ?  "{$phoneStipped}@baucars.com" : $post["email"];
                    $userEntity = new User();
                    $userEntity->setEmail($email)
                        ->setEmailConfirmed(TRUE)
                        ->setFullName($data["fullname"])
                        ->setPhoneNumber($phoneStipped)
                        ->setPassword(UserService::encryptPassword("Simple1"))
                        ->setRegistrationDate(new \DateTime())
                        ->setRegistrationToken(md5(uniqid(mt_rand(), true)))
                        ->setRole($em->find(Role::class, UserService::USER_ROLE_DRIVER))
                        ->setState($em->find(State::class, UserService::USER_STATE_ENABLED))
                        ->setUpdatedOn(new \DateTime())
                        ->setUserUid(UserService::createUserUid())
                        ->setEmailConfirmed(TRUE);
                    $driverEntity = new DriverBio();
                    $driverEntity->setCreatedOn(new \DateTime())
                        ->setDiverUid(DriverService::driverUid())
                        ->setDriverDob(\DateTime::createFromFormat("Y-m-d", $post["driver_dob"]))
                        ->setUser($userEntity)
                        ->setDriverSince(\DateTime::createFromFormat("Y-m-d", $post["driving_since"]));
                    // if()
                    // var_dump($data);
                    $carEntity = new Cars();
                    if ($post["car_platenumber"] != "") {
                        $carEntity->setPlatNumber(strip_tags($post["car_platenumber"]))
                            ->setCreatedOn(new \DateTime())
                            ->setMotorMake($em->find(MotorMake::class, $post["selectedCar"]))
                            ->setMotorName(strip_tags($post["carType"]));
                        
                        $driverEntity->setAssisnedCar($carEntity);
                        
                        $em->persist($carEntity);
                    }
                    
                    $em->persist($driverEntity);
                    $em->persist($userEntity);
                    
                    $em->flush();
                    
                    $response->setStatusCode(201);
                    $jsonModel->setVariable("data", $userEntity->getFullName());
                    
                    $this->flashmessenger()->addSuccessMessage("{$userEntity->getFullName()} successfully created");
                } catch (\Exception $e) {
                    $response->setStatusCode(400);
                    $jsonModel->setVariable("message", $e->getMessage());
                }
            } else {
                $response->setStatusCode(423);
                $jsonModel->setVariable("message", $inputFilter->getMessages());
            }
        }
        return $jsonModel;
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
     * @return the $driverPaginator
     */
    public function getDriverPaginator()
    {
        return $this->driverPaginator;
    }

    /**
     *
     * @param \Driver\Paginator\DriverAdapter $driverPaginator            
     */
    public function setDriverPaginator($driverPaginator)
    {
        $this->driverPaginator = $driverPaginator;
        return $this;
    }
}

