<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 10/07/2014
 * Time: 14:26
 */

namespace CubicMushroom\MessageRedirectBundle\EventListener;


use CubicMushroom\MessageRedirectBundle\Exception\MessageRedirectException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class MessageRedirectListener
{

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

        if ($exception instanceof MessageRedirectException) {
            $message = $exception->getMessage();
            if ( ! empty( $message )) {
                $this->getFlashBag()->add(
                    'message_redirect.message',
                    [ 'message' => $message, 'messageType' => $exception->getMessageType() ]
                );
            }
            $event->setResponse( new RedirectResponse( $exception->getUri() ) );
        }
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

} 