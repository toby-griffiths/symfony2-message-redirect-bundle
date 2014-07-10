<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 10/07/2014
 * Time: 14:32
 */

namespace CubicMushroom\MessageRedirectBundle\Service;


use CubicMushroom\MessageRedirectBundle\Exception\MessageRedirectException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class MessageRedirect
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
     * @var string
     */
    protected $messageRedirectExceptionClass;

    /**
     * Builds the MessageRedirectException
     *
     * @param string      $uri URI to redirect to
     * @param string|null $message
     * @param string      $messageType
     * @param \Exception  $previousException
     *
     * @return MessageRedirectException
     */
    public function createRedirectException(
        $uri,
        $message = null,
        $messageType = 'notice',
        \Exception $previousException = null
    ) {
        $code = 200;
        if ( ! is_null( $previousException )) {
            $code = $previousException->getCode();
        }

        // This line allows the class to be used to be defined in the app config
        $messageRedirectExceptionClass = $this->getMessageRedirectExceptionClass();
        $e                             = new $messageRedirectExceptionClass( $message, $code, $previousException );
        $e->setUri( $uri )
          ->setMessageType( $messageType );

        return $e;
    }

    /**
     * Sets a flash message and then creates and returns a ResponseRedirect object
     *
     * @param $uri
     * @param $message
     * @param $messageType
     *
     * @return RedirectResponse
     */
    public function createRedirectWithMessage( $uri, $message, $messageType )
    {
        if ( ! empty( $message )) {
            $this->getFlashBag()->add(
                'message_redirect.message',
                [ 'message' => $message, 'messageType' => $messageType ]
            );
        }

        return new RedirectResponse( $uri );
    }


    /**
     * @return string
     */
    public function getMessageRedirectExceptionClass()
    {
        return $this->messageRedirectExceptionClass;
    }

    /**
     * @param string $messageRedirectExceptionClass
     *
     * @return $this
     */
    public function setMessageRedirectExceptionClass( $messageRedirectExceptionClass )
    {
        $this->messageRedirectExceptionClass = $messageRedirectExceptionClass;

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
     *
     * @return $this
     */
    public function setDebug( $debug )
    {
        $this->debug = $debug;

        return $this;
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