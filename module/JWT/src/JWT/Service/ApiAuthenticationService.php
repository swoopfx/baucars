<?php
namespace JWT\Service;

use Laminas\InputFilter\InputFilter;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Json\Json;

/**
 *
 * @author mac
 *        
 */
class ApiAuthenticationService implements AuthenticationServiceInterface
{

    private $authenticationService;

    private $auth;

    private $requestObject;

    private $responseObject;

    private $jwtService;

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function authenticate($data)
    {
        $inputFilter = new InputFilter();
        $inputFilter->add(array(
            'name' => 'phoneOrEmail',
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
                            'isEmpty' => 'Phone number or email is required'
                        )
                    )
                )
            )
        ));
        
        $inputFilter->add(array(
            'name' => 'password',
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
                            'isEmpty' => 'Password is required'
                        )
                    )
                )
            )
        ));
        
        $inputFilter->setData($data);
        
        if ($inputFilter->isValid()) {
            $data = $inputFilter->getValues();
            
            $authService = $this->authenticationService;
            $adapter = $authService->getAdapter();
            $phoneOrEmail = $data["username"];
            
            $user = $this->entityManager->createQuery("SELECT u FROM CsnUser\Entity\User u WHERE u.email = '$phoneOrEmail' OR u.phoneNumber = '$phoneOrEmail'")->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
            if (count($user) == 0) {
                $response->setCustomStatusCode(498);
                $response->setReasonPhrase('Invalid token!');
                return $jsonModel->setVariables([
                    "messages" => "The username or email is not valid!"
                ]);
                
                throw new 
            }
        } else {
            return Json::encode($inputFilter->getMessages());
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Laminas\Authentication\AuthenticationServiceInterface::hasIdentity()
     */
    public function hasIdentity()
    {
        // TODO Auto-generated method stub
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Laminas\Authentication\AuthenticationServiceInterface::getIdentity()
     */
    public function getIdentity()
    {
        // TODO Auto-generated method stub
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Laminas\Authentication\AuthenticationServiceInterface::clearIdentity()
     */
    public function clearIdentity()
    {
        // TODO Auto-generated method stub
    }

    /**
     *
     * @return the $authenticationService
     */
    public function getAuthenticationService()
    {
        return $this->authenticationService;
    }

    /**
     *
     * @return the $auth
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     *
     * @return the $requestObject
     */
    public function getRequestObject()
    {
        return $this->requestObject;
    }

    /**
     *
     * @return the $responseObject
     */
    public function getResponseObject()
    {
        return $this->responseObject;
    }

    /**
     *
     * @param field_type $authenticationService            
     */
    public function setAuthenticationService($authenticationService)
    {
        $this->authenticationService = $authenticationService;
        return $this;
    }

    /**
     *
     * @param field_type $auth            
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     *
     * @param field_type $requestObject            
     */
    public function setRequestObject($requestObject)
    {
        $this->requestObject = $requestObject;
        return $this;
    }

    /**
     *
     * @param field_type $responseObject            
     */
    public function setResponseObject($responseObject)
    {
        $this->responseObject = $responseObject;
        return $this;
    }
}

