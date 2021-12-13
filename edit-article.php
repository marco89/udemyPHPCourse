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

// if a form is submitted, this populates the fields with the input data and validates them with 
// the validateArticle function
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // $_POST variable is used to collect values from a form with method="post"

    // assigns what the user inputs on the form (this is what $_POST does) to 
    // the empty variables created at the beginning so they can be used in the
    // HTML that's at the bottom of this file
    
    $title = $_POST['title'];

    $content = $_POST['content'];

    $published_at = $_POST['published_at'];

    // calls the validateArticle function and assigns its return value to the $errors array
    $errors = validateArticle($title, $content, $published_at);

    if (empty($errors)) {

        // sql statement using ? as placeholders
        $sql = "UPDATE article
                SET title = ?,
                    content = ?,
                    published_at = ?
                WHERE id = ?";

        // makes a prepared statement to stop injections
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt === false) {

            echo mysqli_error($conn);
        } else {
            
            // sets the published_at var to null if user inputs nothing in published_at field of the form
            if ($published_at == '') {
                $published_at = null;
            }

            //binds the last 3 args to use as placeholders in the sql variable above (s for string, i for integer etc)
            mysqli_stmt_bind_param($stmt, "sssi", $title, $content, $published_at, $id);

            if (mysqli_stmt_execute($stmt)) {

                redirect("/udemy/article.php?id=$id");

            } else {

                echo mysqli_stmt_error($stmt);
            }
        }
    }
}


?>
<?php require 'includes/header.php'; ?>

<a href='index.php'><button>Homepage</button></a>

<h2>Edit article</h2>

<?php require 'includes/article-form.php'; ?>
    
<?php require 'includes/footer.php'; ?>