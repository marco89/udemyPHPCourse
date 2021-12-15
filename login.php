<?php

// requires the file that contains the redirect function
require 'includes/url.php';

// creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie. 
session_start();

// checks whether POST method is used 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // checks user credentials
    if ($_POST['username'] == 'cms_www' && $_POST['password'] == 'ooSgk2)yoWsYj*z8') {

        // creates a new session ID to prevent Session Fixation Attacks
        // https://owasp.org/www-community/attacks/Session_fixation
        session_regenerate_id(true);

        $_SESSION['is_logged_in'] = true;

        // if credentials are correct, redirects back to index page
        redirect('/udemy');

    } 
    else
    {

        // if credentials are wrong, pushes login error message to $error variable
        $error = "login incorrect";

    }
}

?>
<?php require 'includes/header.php'; ?>

<h2>Login</h2>

<!-- if $error var isn't empty i.e. if credentials are wrong, print $error -->
<?php if (! empty($error)) : ?>
    <p><?= $error ?></p>
<?php endif; ?>

<!-- specifying the POST method ensures that login details dont appear in URL -->
<form method="post">

    <!-- adds username input and placeholder -->
    <div>
        <label for="username">Username</label>
        <input name="username" id="username">
    </div>

    <!-- adds pw input and placeholder -->
    <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </div>

    <button>Log in</button>

</form>

<?php require 'includes/footer.php'; ?>
