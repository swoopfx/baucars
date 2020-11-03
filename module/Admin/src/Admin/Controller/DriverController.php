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

    // private
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function driversAction()
    {
        $viewModel = new ViewModel();
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
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $inputFilter = new InputFilter();
            $inputFilter->add(array(
                'name' => 'fullname',
                'required' => true,
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
            
            if ($inputFilter->isValid()) {
                $data = $inputFilter->getValues();
                $email = $data["email"] ?? "{$data["phoneNumber"]}@baucars.com";
                $userEntity = new User();
                $userEntity->setEmail($email)
                    ->setEmailConfirmed(TRUE)
                    ->setFullName($data["fullName"])
                    ->setPhoneNumber(str_replace("-", "", $data["phoneNumber"]))
                    ->setPassword(UserService::encryptPassword($data["password"]))
                    ->setRegistrationDate(new \DateTime())
                    ->setRegistrationToken(md5(uniqid(mt_rand(), true)))
                    ->setRole($em->find(Role::class, UserService::USER_ROLE_DRIVER))
                    ->setState($em->find(State::class, UserService::USER_STATE_ENABLED))
                    ->setUpdatedOn(new \DateTime())
                    ->setUserUid(UserService::createUserUid())
                    ->setEmailConfirmed(TRUE);
                $driverEntity = new DriverBio();
                $driverEntity->setCreatedOn(new \DateTime())
                    ->setDriverDob($data["driver_dob"])
                    ->setDriverDob($data["driver_dob"]);
                
               $em->persist($driverEntity);
               $em->persist($userEntity);
               
               $em->flush();
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
}

