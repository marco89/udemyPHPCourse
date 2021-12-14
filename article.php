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

    <a href="/udemy/edit-article.php?id=<?= $article['id']; ?>"><button>Edit article</button></a>
    <!-- link to the delete article link, have to use a form instead of a link and
         so you have to use POST instead of GET -->
    <form method="post" action="delete-article.php?id=<?= $article['id']; ?>">
        <button>Delete article</button>
    </form>

<?php endif; ?>
<?php require 'includes/footer.php'; ?>