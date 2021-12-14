<?php

require 'includes/database.php';
require 'includes/article.php';
require 'includes/url.php';

$conn = getDB();

if (isset($_GET['id'])) {

    $article = getArticle($conn, $_GET['id']);

    if ($article) {
        // data coming from db is in assoc array so this assigns values to the expected variables
        $id = $article['id'];
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

/* checks whether POST request method is being used, this ensures you can't delete an article 
simply by going to localhost/delete-article.php?id=? and accessing the delete article script
and instead must actually send the command i.e. use the POST method */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

$sql = "DELETE FROM article
        WHERE id = ?";

// makes a prepared statement to stop injections
$stmt = mysqli_prepare($conn, $sql);

if ($stmt === false) {

    echo mysqli_error($conn);
} else {

    //binds the last 3 args to use as placeholders in the sql variable above (s for string, i for integer etc)
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {

        redirect("/udemy/index.php");
    } else {

        echo mysqli_stmt_error($stmt);
    }
}
}