Message Redirect Bundle
=======================

Introduction
------------

Symfony2 bundle that provides service for conveniently redirecting the user from wherever you are in the call stack, and
displaying a message to the user.

It does this by throwing a MessageRedirectException that is then caught by the MessageRedirectListener which adds the
message to the session flahsBag, andthen redirects the user to the specified URI.
 
If a previous exception is passed in to the MessageRedirectException, and the current environment has debugging enabled,
then the exception will not trigger a redirect, and the exception will be displayed to the user, including the previous 
exception thrown.


Installation
------------

To use this bundle follow these steps...

1. Add the bundle using composer
    
        "require": {
            "cubicmushroom/symfony-error-redirect": "dev-master"
        }
    
2. Register the bundle in app/AppKernel.php

        class AppKernel extends Kernel
        {
            // ...
    
            public function registerBundles()
            {
                $bundles = array(
                    // ...
                    new CubicMushroom\MessageRedirectBundle\CubicMushroomMessageRedirectBundle(),
                );
                
                // ...
        
                return $bundles;
            }
            
            // ...
        }

3. Add the message template to your view template (probably best at the base template level to avoid having ot remember
   to each view
    
        {{ include('CubicMushroomMessageRedirectBundle:elements:message.html.twig') }}
    
   To add your own classes to the flash messages, define the flashClasses twig variable before calling the inlude
   
        {% set flashClasses = 'alert' %}
        {{ include('CubicMushroomMessageRedirectBundle:elements:message.html.twig') }}
        
        
Usage
-----

### Redirect

There are 1 ways to rediect...

1. Use the service's createRedirectWithMessage() method and returning this from your controller.

        // If within object with a Container object
        return $this->container->get('message_redirect')->createRedirectWithMessage( $uri, $message, $messageClass );
        
2. Create and throw a RedirectMessageException

        // If within object with a Container object
        thrown $this->container->get('message_redirect')->createRedirectException(
            $uri,
            $message,          // optional
            messageType,       // optional
            $previousException // optional
        );
        
### Using different Exception class to redirect
    
To use your own exception class for the redirects, simply set the %message_redirect.exception.message_redirect.class%
parameter to another exception class that implements the 
\CubicMushroom\MessageRedirectBundle\Exception\MessageRedirectExceptionInterface interface

To use your own exception on for a single request, you can set the exception class on the service by doing the following...

    $this->container->get('message_redirect')->setMessageRedirectExceptionClass( $class );
    // Then call createRedirectWithMessage() to create the exception to throw