<?php

/**
 * Redirects to another URL on the same site
 * 
 * @param string $path The path to redirect to
 * 
 * @return void
 */
function redirect($path)
{
    //isset checks whether a variable is detected and is different to Null

                // next 5 lines of code ensures the new article redirect works in every browser by 
                // creating an absolute URL which is a URL that contains both the protocol
                // and the server name. This means instead of hardcoding the redirect location,
                // we can instead use the $_SERVER superglobal to get this information

                // checks the protocol (protocol is a set of rules or procedures for transmitting 
                // data between electronic devices) i.e. is the server using https or http
    if (isset($_SERVER['HTPS']) && $_SERVER['HTTPS'] != 'off') {
        $protocol = 'https';
    } else {
        $protocol = 'http';
    }
    
    // redirects to the article in question (via an absolute URL) when it's added by using
    // the header function
    // the protocol type is being taken from the previous if statement, that is being 
    // concatenated with the server name and then the file path
    header("Location: $protocol://" . $_SERVER['HTTP_HOST'] . $path);
    exit;
}
