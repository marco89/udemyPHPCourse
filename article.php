<?php

require 'includes/database.php';
require 'includes/article.php';


$conn = getDB();

// avoids sql injection by ensuring the input is numeric
if (isset($_GET['id'])) {

    $article = getArticle($conn, $_GET['id']);
    }
    else
    {
        $article = null;
    }

?>

<p align="center">
    <a href='index.php'><button>Homepage</button></a>
</p>


<?php require 'includes/header.php'; ?>
<?php if ($article === null) : ?>
    <p>Article not found.</p>
<?php else : ?>

    <article>
        <h2><?= $article['title']; ?></h2>
        <p><?= $article['content']; ?></p>
    </article>

<?php endif; ?>
<?php require 'includes/footer.php'; ?>