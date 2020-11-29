<?php
namespace General\Service;

use Doctrine\ORM\EntityManager;
use Zend\Authentication\AuthenticationService;

/**
 *
 * @author otaba
 *        
 */
class GeneralService
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var AuthenticationService
     */
    private $auth;

    private $mailService;

    private $renderer;

    const COMPANY_NAME = "BAU Cars Limited";

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     * This function is used to send mails form any controller or service
     * If there is going to be a complex AddCC or addBcc Request,It should be done in the controller
     *
     * @param array $messagePointers            
     * @param array $template            
     */
    public function sendMails($messagePointers = array(), $template = array(), $replyTo = "", $addCc = "", $addBcc = "")
    {
        
        $mailService = $this->mailService;
        // $der = new Message();
        $message = $mailService->getMessage();
        $message->addTo($messagePointers['to'])
            ->setFrom("admin@baucars.com", ($messagePointers['fromName'] == NULL ? self::COMPANY_NAME : $messagePointers["fromName"]))
            ->setSubject($messagePointers['subject']);
        
        if ($replyTo != "") {
            $message->setReplyTo($replyTo);
        }
        
        if ($addCc != "") {
            $message->addCc($addCc);
        }
        
        if ($addBcc != "") {
            $message->addBcc($addBcc);
        }
        
        $mailService->setTemplate($template['template'], $template['var']);
        
        $mailService->send();
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
     * @param field_type $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
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
     * @param field_type $auth            
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     *
     * @return the $mailService
     */
    public function getMailService()
    {
        return $this->mailService;
    }

    /**
     *
     * @param field_type $mailService            
     */
    public function setMailService($mailService)
    {
        $this->mailService = $mailService;
        return $this;
    }

    /**
     *
     * @return the $renderer
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     *
     * @param field_type $renderer            
     */
    public function setRenderer($renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }
}

