<?php

var_dump($_SERVER['QUERY_STRING']);

var_dump($_GET);

<?php

$posts = [1 => 'Good news', 3 => 'Read this', 5 => 'Important announcement'];

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Posts</title>
    </head>
    <body>

    <h1>Posts</h1>

    <ul>
        <?php foreach($posts as $id => $title): ?>
        
            <li><a href ='post.php?id=1'>Good news</a></li>
            <li><a href ='post.php?id=3'>Read this</a></li>
            <li><a href ='post.php?id=5'>Important announcement</a></li>
            
        <?php endforeach; ?>
    </ul>

    </body>
</html>