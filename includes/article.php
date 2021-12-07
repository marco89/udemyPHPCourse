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

    // turns sql query into prepared statement so as to avoid sql injection
    $preparedStmt = mysqli_prepare($conn, $sql);

    // checks if there's an error and if there is, error is printed
    if ($preparedStmt === false) 
    {
        echo mysqli_error($conn);
    }
    else
    {
        // binds parameter to the placeholder and passes in the $id argument and setting it as an int 
        mysqli_stmt_bind_param($preparedStmt, "i", $id);

        //executes the sql statement which returns true if succesful 
        if (mysqli_stmt_execute($preparedStmt))
        {
            // $result is the result of the sql statement 
           $result =  mysqli_stmt_get_result($preparedStmt);

           // returns an associative array based on $result variable which 
           // in turn is the result of the sql query
           return mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
    }
}