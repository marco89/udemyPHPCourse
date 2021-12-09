<?php

require 'includes/database.php';
require 'includes/article.php';

$conn = getDB();

if (isset($_GET['id'])) {

    $article = getArticle($conn, $_GET['id']);

    if ($article) {
    // data coming from db is in assoc array so this assigns values to the expected variables
    $title = $article['title'];
    $content = $article['content'];
    $published_at = $article['published_at'];

    } else {
        // exits the script if the if statement above returns false/null
        die("Article not found");
    }

} else {
    // this is displayed if the article ID isn't passed into the url
    die("ID not supplied, article not found");
}

// if a form is submitted, this populates the fields with the input data and validates them with 
// the validateArticle function
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // $_POST variable is used to collect values from a form with method="post"

    // assigns what the user inputs on the form (this is what $_POST does) to 
    // the empty variables created at the beginning so they can be used in the
    //HTML that's at the bottom of this file
    $title = $_POST['title'];

    $content = $_POST['content'];

    $published_at = $_POST['published_at'];

    // calls the validateArticle function and assigns its return value to the $errors array
    $errors = validateArticle($title, $content, $published_at);

    if (empty($errors)) {
        die("form is valid");
    }
}

?>
<?php require 'includes/header.php'; ?>

<h2>Edit article</h2>
    
<?php require 'includes/article-form.php'; ?>
    
<?php require 'includes/footer.php'; ?>