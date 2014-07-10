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
     * Builds the MessageRedirectException
     *
     * @param string      $uri URI to redirect to
     * @param string|null $message
     * @param string      $messageType
     * @param int         $code
     * @param \Exception  $previousException
     *
     * @throws MessageRedirectException
     */
    public function redirect(
        $uri,
        $message = null,
        $messageType = 'notice',
        $code = 0,
        \Exception $previousException = null
    ) {
        $e = new MessageRedirectException( $message, $code, $previousException );
        $e->setUri( $uri )
          ->setMessageType( $messageType );

        throw $e;
    }
} 