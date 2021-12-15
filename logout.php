<?php

require 'includes/url.php';

// creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie. 
session_start();

// Unsets all the sessions variables by clearing the $_SESSION variable and setting it to an empty array
$_SESSION = array();

// Below deletes the session cookie, specifically it kills the session and not just the session data

// checks whether the session if using cookies using an if statement
if (ini_get("session.use_cookies")) {
    // if it does use cookies, the following code deletes all the cookie data
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// destroys all the data from the session
session_destroy();

redirect('/udemy');