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

?>
<?php require 'includes/header.php'; ?>

<h2>Edit article</h2>
    
<?php require 'includes/article-form.php'; ?>
    
<?php require 'includes/footer.php'; ?>