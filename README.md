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

To use the redirect functionality, at any time, use the `message_redirect` service to create a MessageRedirectException
object to then throw.
    
1. To redirect the user at any point within the call stack, simply call the `redirect()` method on the 
   `message_redirect` service...
   
        thrown $this->container->get('message_redirect')->createRedirectException(
            $uri,
            $message,
            $messageType,
            $code,
            $previousException
        );
    
2. Style your flash messages using the following css rules

        .mr-flash-notice {
            ...
        }
        .mr-flash-notice.error {
            ...
        }
        
   (or use your own styles added, as described above)