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
     * @param string $uri URI to redirect to
     * @param string|null $message
     * @param string $messageType
     * @param \Exception $previousException
     * @param int $code
     *
     * @throws \CubicMushroom\MessageRedirectBundle\Exception\MessageRedirectException
     */
    public function redirect(
        $uri,
        $message = null,
        $messageType = 'notice',
        \Exception $previousException = null,
        $code = 0
    ) {
        $e = new MessageRedirectException( $message, $code, $previousException );
        $e->setUri( $uri )
          ->setMessageType( $messageType );

        throw $e;
    }
} 