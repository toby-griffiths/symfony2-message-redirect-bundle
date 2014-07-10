<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 10/07/2014
 * Time: 19:18
 */

namespace CubicMushroom\MessageRedirectBundle\Exception;


interface MessageRedirectExceptionInterface {

    /**
     * @return string
     */
    public function getMessageType();

    /**
     * @param string $messageType
     *
     * @return $this
     */
    public function setMessageType( $messageType );

    /**
     * @return string
     */
    public function getUri();

    /**
     * @param string $uri
     *
     * @return $this
     */
    public function setUri( $uri );
}