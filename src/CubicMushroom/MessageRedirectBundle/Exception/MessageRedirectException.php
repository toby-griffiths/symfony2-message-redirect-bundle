<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 10/07/2014
 * Time: 14:28
 */

namespace CubicMushroom\MessageRedirectBundle\Exception;

/**
 * Class MessageRedirectException
 *
 * @package CubicMushroom\MessageRedirectBundle\Exception
 *
 * This exception class can be used to automatically redirect to a given page from wherever you are within the call
 * stack, as the exception will bubble up the stack and then get handled by the Kernel's Exception handler, which in
 * turn triggers the KernelEvents::EXCEPTION event, that this bundle's MessageRedirectListener handles
 */
class MessageRedirectException extends Exception
{
    /**
     * @var string
     */
    protected $uri;

    /**
     * @var string
     */
    protected $messageType;

    /**
     * @return string
     */
    public function getMessageType()
    {
        return $this->messageType;
    }

    /**
     * @param string $messageType
     *
     * @return $this
     */
    public function setMessageType( $messageType )
    {
        $this->messageType = $messageType;

        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     *
     * @return $this
     */
    public function setUri( $uri )
    {
        $this->uri = $uri;

        return $this;
    }
} 