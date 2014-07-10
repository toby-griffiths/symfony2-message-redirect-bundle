<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 10/07/2014
 * Time: 14:32
 */

namespace CubicMushroom\MessageRedirectBundle\Service;


use CubicMushroom\MessageRedirectBundle\Exception\MessageRedirectException;

class MessageRedirect
{
    /**
     * App's debug status
     *
     * @var bool
     */
    protected $debug;

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
} 