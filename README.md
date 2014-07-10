Message Redirect Bundle
=======================

Introduction
------------

Symfony2 bundle that provides service for conveniently redirecting the user from wherever you are in the call stack, and
displaying a message to the user.

It does this by throwing a MessageRedirectException that is then caught by the MessageRedirectListener which adds the
message to the session flahsBag, andthen redirects the user to the specified URI. 


Installation
------------

To use this bundle follow these steps...

1. Add the bundle using composer
    
    "require": {
        "cubicmushroom/symfony-error-redirect": "dev-master"
    }
    
2. Register the bundle in app/AppKernel.php
3. Add the message template to your view template (probably best at the base template level to avoid having ot remember
   to each view
    
    {{ include('CubicMushroomMessageRedirectBundle:elements:message.html.twig') }}
    
4. To redirect the user at any point within the call stack, simply call the `redirect()` method on the 
   `message_redirect` service...
   
    $this->container->get('message_redirect')->redirect(
        $uri,
        $message,
        $messageType,
        $code,
        $previousException
    );