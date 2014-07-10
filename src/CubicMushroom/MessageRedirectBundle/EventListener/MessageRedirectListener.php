<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 10/07/2014
 * Time: 14:26
 */

namespace CubicMushroom\MessageRedirectBundle\EventListener;


use CubicMushroom\MessageRedirectBundle\Exception\MessageRedirectExceptionInterface;
use CubicMushroom\MessageRedirectBundle\Service\MessageRedirect;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class MessageRedirectListener
{
    /**
     * App's debug status
     *
     * @var bool
     */
    protected $debug;

    /**
     * @var MessageRedirect
     */
    protected $messageRedirectService;

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException( GetResponseForExceptionEvent $event )
    {
        $exception = $event->getException();

        // Only process MessageRedirectExceptions
        if ( ! $exception instanceof MessageRedirectExceptionInterface) {
            return;
        }

        /** @var \Exception|MessageRedirectExceptionInterface $exception */

        // If debugging is enabled, and the code is not a 200 then don't intercept the redirect
        if ($this->isDebug() && 200 !== $exception->getCode()) {
            return;
        }

        $uri = $exception->getUri();
        $message = $exception->getMessage();
        $messageType = $exception->getMessageType();

        $redirect = $this->getMessageRedirectService()->createRedirectWithMessage( $uri, $message, $messageType );

        $event->setResponse( $redirect );
    }

    /**
     * @return boolean
     */
    public function isDebug()
    {
        return $this->debug;
    }

    /**
     * @param boolean $debug
     *
     * @return $this
     */
    public function setDebug( $debug )
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     * @return MessageRedirect
     */
    public function getMessageRedirectService()
    {
        return $this->messageRedirectService;
    }

    /**
     * @param MessageRedirect $messageRedirectService
     */
    public function setMessageRedirectService( $messageRedirectService )
    {
        $this->messageRedirectService = $messageRedirectService;

        return $this;
    }

} 