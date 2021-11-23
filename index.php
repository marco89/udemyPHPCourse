<?php


require 'includes/database.php';

$conn = getDB();

$sql = "SELECT *
        FROM article
        ORDER BY published_at;";

$results = mysqli_query($conn, $sql);

if ($results === false) {
    echo mysqli_error($conn);
} else {
    $articles = mysqli_fetch_all($results, MYSQLI_ASSOC);
}

?>

<p align="center">
    <a href='new-article.php'><button>Add article to database</button></a>
</p>

<?php require 'includes/header.php'; ?>
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

