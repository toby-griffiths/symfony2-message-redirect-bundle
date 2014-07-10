<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 10/07/2014
 * Time: 14:26
 */

namespace CubicMushroom\MessageRedirectBundle\EventListener;


use CubicMushroom\MessageRedirectBundle\Exception\MessageRedirectExceptionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
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
     * @var FlashBagInterface
     */
    protected $flashBag;

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

        $message = $exception->getMessage();
        if ( ! empty( $message )) {
            $this->getFlashBag()->add(
                'message_redirect.message',
                [ 'message' => $message, 'messageType' => $exception->getMessageType() ]
            );
        }
        $event->setResponse( new RedirectResponse( $exception->getUri() ) );
    }

    /**
     * @return FlashBagInterface
     */
    public function getFlashBag()
    {
        return $this->flashBag;
    }

    /**
     * @param FlashBagInterface $flashBag
     *
     * @return $this
     */
    public function setFlashBag( FlashBagInterface $flashBag )
    {
        $this->flashBag = $flashBag;

        return $this;
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
     */
    public function setDebug( $debug )
    {
        $this->debug = $debug;
    }

} 