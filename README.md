Message Redirect Bundle
=======================

Introduction
------------

Symfony2 bundle that provides convenience MessageRedirectException, as well as a Kernel exception event listener that 
catches any MessageRedirectException thrown.

If a MessageRedirectException is thrown then any message provided is added to the session's flashbag, and then the user 
id redirected to the URI set in the MessageRedirectException.