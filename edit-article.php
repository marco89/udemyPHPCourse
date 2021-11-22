<?php

require 'includes/database.php';
require 'includes/article.php';

$conn = getDB();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $article = getArticle($conn, $_GET['id']);
    }
    else
    {
        $article = null;
    }

?>