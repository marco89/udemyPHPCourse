<?php

require 'includes/database.php';
require 'includes/article.php';
require 'includes/url.php';

// creates an empty errors variable which error messages will be later pushed to
$errors = [];

// creates an empty string to act as a place to maintain previously input data if user
// input is deemed to be wrong i.e. if one bit of data is correctly input and another 
// bit of data is not.
$title = '';

// does the same for content and published_at
$content = '';

$published_at = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // $_POST variable is used to collect values from a form with method="post"

    // assigns what the user inputs on the form (this is what $_POST does) to 
    // the empty variables created at the beginning so they can be used in the
    //HTML that's at the bottom of this file
    $title = $_POST['title'];

    $content = $_POST['content'];

    $published_at = $_POST['published_at'];

    // calls the validateArticle function and assigns its return value to the $errors array
    if ($title == '') {
        $errors[] = 'Title is required';
    }
    if ($content == '') {
        $errors[] = 'Content is required';
    }
    
    if ($published_at != '') {
        $date_time = date_create_from_format('Y-m-d H:i:s', $published_at);

        if ($date_time === false or $date_time === '') {
            $errors[] = 'Invalid date and time';
        }
    }

    if (empty($errors)) {

        $conn = getDB();

        // sql statement using ? as placeholders
        $sql = "INSERT INTO article (title, content, published_at) VALUES (?, ?, ?)";

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
            mysqli_stmt_bind_param($stmt, "sss", $title, $content, $published_at);

            if (mysqli_stmt_execute($stmt)) {

                $id = mysqli_insert_id($conn);
                
                // the path we want to direct to
                redirect("/udemy/article.php?id=$id");

            } else {

                echo mysqli_stmt_error($stmt);
            }
        }
    }
}


?>

<p align="center">
    <a href='index.php'><button>Homepage</button></a>
</p>


<?php require 'includes/header.php'; ?>

<h2>New article</h2>

<?php require 'includes/article-form.php'; ?>

<?php require 'includes/footer.php'; ?>