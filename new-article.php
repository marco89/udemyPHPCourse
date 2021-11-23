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

    // assigns what the user inputs on the form (this is what $_POST does) to 
    // the empty variables created at the beginning so they can be used in the
    //HTML that's at the bottom of this file
    $title = $_POST['title'];

    $content = $_POST['content'];

    $published_at = $_POST['published_at'];

    // next ~10 lines validates user input
    // checks whether title field is empty
    if ($title == '') {
        // adds following str to errors arr if it is empty i.e. if user doesn't input anything
        $errors[] = 'Title is required';
    }
    // checks whether content field is empty
    if ($content == '') {
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

            //binds the last 3 args to use as placeholders in the sql variable above (s for string, i for integer etc)
            mysqli_stmt_bind_param($stmt, "sss", $title, $content, $published_at);

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
        <!-- uses the result of the $_POST variable that is from the title field of the user input form,
        it only comprises things between the first and second set of quotes -->
        <input name='title' id='title' placeholder='Article title' value="<?= htmlspecialchars($title); ?>">
    </div>

    <!-- NOTE: if a string containing a quote is inserted in place of the value, such as the string
    "">danger", this opens up the possibility of a cross-site scripting (XSS) attack. This is because
    everything after the second quote is taken as HTML and not as the attribute it was intended to be.
    This means you could potentially place in some malicious HTML code which could lead to a code injection
    which would allow an attacker to harvest cookies or logins. -->         
    
    <!-- the use of the htmlspecialchars() function allows us to display reserved characters like quotes
    or less/greater than symbols without opening ourselves up to XSS attacks. -->

    <div>
        <label for='content'>Content</label>
        <!-- again using the $_POST var for the content field instead of title -->
        <textarea name='content' rows='4' cols='40' id='content' 
                  placeholder='Article content'><?= htmlspecialchars($content); ?></textarea>
    </div>

    <div>
        <label for='published_at'>Publication date and time</label>
        <input type='datetime-local' name='published_at' id='published_at'
               value="<?= htmlspecialchars($published_at); ?>">
    </div>

    <button>Add</button>

</form>

<?php require 'includes/footer.php'; ?>