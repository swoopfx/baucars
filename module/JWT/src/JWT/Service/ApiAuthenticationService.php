<?php
namespace JWT\Service;

use Laminas\InputFilter\InputFilter;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Json\Json;
use Laminas\Http\Request;

/**
 *
 * @author mac
 *        
 */
class ApiAuthenticationService implements AuthenticationServiceInterface
{

    private $authenticationService;

    private $auth;

    /**
     *
     * @var Request
     */
    private $requestObject;

    private $responseObject;

    /**
     *
     * @var JWTService
     */
    private $jwtService;

    /**
     *
     * @var string
     */
    private $token;

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
                
                throw new Exception("The username or email is not valid!");
            }
            
            $user = $user[0];
            
            if (! $user->getEmailConfirmed() == 1) {
                throw new Exception("You are yet to confirm your email! please go to the registered email to confirm your account");
            }
            if ($user->getState()->getId() < 2) {
                throw new Exception("Your account is disabled");
            }
            
            $adapter->setIdentity($user->getPhoneNumber());
            $adapter->setCredential($data["password"]);
            
            $authResult = $authService->authenticate();
            
            if ($authResult->isValid()) {
                $identity = $authResult->getIdentity();
                $authService->getStorage()->write($identity);
                
                // generate jwt token
                return $this->jwtService->generate($user->getId());
            } else {
                throw new Exception("Invalid Credentials");
            }
        } else {
            throw new Exception(Json::encode($inputFilter->getMessages()));
        }
    }

    private function getAuthorizationHeader()
    {
        $requestObject = $this->requestObject;
        $authorizationHeader = $requestObject->getHeader('Authorization')->getFieldValue();
        return $authorizationHeader;
    }

    private function getBearerToken()
    {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (! empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Laminas\Authentication\AuthenticationServiceInterface::hasIdentity()
     */
    public function hasIdentity()
    {
        if ($this->getIdentity() instanceof Exception) {
            return false;
        } else {
            return true;
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Laminas\Authentication\AuthenticationServiceInterface::getIdentity()
     */
    public function getIdentity()
    {
        //
        $jwt = $this->getBearerToken();
        $jwtServe = $this->jwtService;
        try {
            $token = $jwtServe->validate($jwt);
            $uid = $token->claims()->get("uid");
            return $uid;
        } catch (Exception $e) {
            return $e->getMessage();
        }
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

    /**
     *
     * @return the $jwtService
     */
    public function getJwtService()
    {
        return $this->jwtService;
    }

    /**
     *
     * @param \General\Service\JwtService $jwtService            
     */
    public function setJwtService($jwtService)
    {
        $this->jwtService = $jwtService;
        return $this;
    }
}

