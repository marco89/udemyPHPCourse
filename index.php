<?php

/** article-form.php CURRENTLY BROKEN, DOESN'T SHOW THE ARTICLE BOX LABEL, HEADER AND FORMATTING
 *  IS WEIRD. HAPPENED AFTER IMPLEMENTING THE LOGGED IN USER ONLY RESTRICTION FROM SECTION 98.
 */

require 'classes/Database.php';
require 'includes/auth.php';

session_start();

// creates a new db object
$db = new Database();
// gets connection by calling the method from the db class
$conn = $db->getDB(); 

$sql = "SELECT *
        FROM article
        ORDER BY published_at;";

$results = $conn->query($sql);

if ($results === false) {
    // displays an array of error details if results throws out a false
    var_dump($conn->errorInfo());
}
else
{
    // displays all results as an array, 
    $articles = $results->fetchAll(PDO::FETCH_ASSOC);
}
 
?>


<?php require 'includes/header.php'; ?>

<!-- below is an example of an if else statement that's in HTML but contained in short one line php -->

<!-- this checks whether user is logged in and displays a message if so  as well as providing logout link
     it also checks whether we have called login -->
<?php if (isLoggedIn()): ?>

    <p>You are currently logged in <br> <a href="logout.php">Log out</a></p>
    <p align="center">
    <a href='new-article.php'><button>Add article to database</button></a>
    </p>
    
<?php else: ?>

<!-- does the same as above but reversed -->
    <p>You are not currently logged in <br> <a href="login.php">Log in</a></p>

<?php endif; ?>


<?php if (empty($articles)) : ?>
    <p>No articles found.</p>
<?php else : ?>

    <ul>
        <?php foreach ($articles as $article) : ?>
            <li>
                <article>
                    <!-- Use of the htmlspecialchars() function prevents XSS attacks by stopping attackers injecting
                    malicious HTML/JS via the input fields of the form. ID doesn't need to use the function as ID will
                    always be an int. NOTE a user should never be able to input something like <strong>String</strong> 
                    and it be displayed as an emboldened string. It should only ever display as the code itself, making
                    sure that the browser is not interpreting and displaying the HTML itself -->
                    <h2><a href="article.php?id=<?= $article['id']; ?>"><?= htmlspecialchars($article['title']); ?></a></h2>
                    <p><?= htmlspecialchars($article['content']); ?></p>
                </article>
            </li>
        <?php endforeach; ?>
    </ul>

<?php endif; ?>
<?php require 'includes/footer.php'; ?>
