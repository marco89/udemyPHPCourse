<?php

require 'includes/database.php';

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

    // assigns 
    $title = $_POST['title'];
    $content = $_POST['content'];
    $published_at = $_POST['published_at'];

    // next ~10 lines validates user input
    // checks whether title field is empty
    if ($_POST['title'] == '') {
        // adds following str to errors arr if it is empty
        $errors[] = 'Title is required';
    }
    // checks whether content field is empty
    if ($_POST['content'] == '') {
        // adds following str to errors arr if it is empty
        $errors[] = 'Content is required';
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

            mysqli_stmt_bind_param($stmt, "sss", $_POST['title'], $_POST['content'], $_POST['published_at']);

            if (mysqli_stmt_execute($stmt)) {

                $id = mysqli_insert_id($conn);
                echo "Inserted record with ID: $id";
            } else {

                echo mysqli_stmt_error($stmt);
            }
            var_dump($errors);
        }
    }
}


?>

<p align="center">
    <a href='index.php'><button>Homepage</button></a>
</p>


<?php require 'includes/header.php'; ?>

<h2>New article</h2>

<?php if (!empty($errors)) : ?>
    <ul>
        <?php // uses a foreach loop to iterate through every array index 
        ?>
        <?php foreach ($errors as $error) : ?>
            <?php // <?= is shorthand for <?php echo 
            ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method='post'>

    <div>
        <label for='title'>Title</label>
        <input name='title' id='title' placeholder='Article title' value="<?= $title; ?>">
    </div>

    <div>
        <label for='content'>Content</label>
        <textarea name='content' rows='4' cols='40' id='content' placeholder='Article content'></textarea>
    </div>

    <div>
        <label for='published_at'>Publication date and time</label>
        <input type='datetime-local' name='published_at' id='published_at'>
    </div>

    <button>Add</button>

</form>

<?php require 'includes/footer.php'; ?>