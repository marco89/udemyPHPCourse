<?php


/** entire function gets the article record based on the ID
 * 
 * @param object $conn is the connection the db
 * @param integer $id is the article ID
 * 
 * @return mixed Returns an associative array which contains the article with the
 * corresponding ID or returns null if it doesn't find anything
 */
function getArticle($conn, $id)
{
    $sql = "SELECT *
            FROM ARTICLE
            WHERE id = ?";       

    $preparedStmt = mysqli_prepare($conn, $sql);

    if ($preparedStmt === false) 
    {
        echo mysqli_error($conn);
    }
    else
    {
        mysqli_stmt_bind_param($preparedStmt, "i", $id);

        if (mysqli_stmt_execute($preparedStmt))
        {
           $result =  mysqli_stmt_get_result($preparedStmt);

           return mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
    }
}