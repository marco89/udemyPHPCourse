<?php


/** entire function gets the article record based on the ID
 * 
 * @param object $conn is the connection the db
 * @param integer $id is the article ID
 * @param string $columns Optional list of columns for select statements, defaults to *
 * 
 * @return mixed Returns an associative array which contains the article with the
 * corresponding ID or returns null if it doesn't find anything
 */
function getArticle($conn, $id, $columns = '*')
{
    $sql = "SELECT $columns
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

/** 
 * Validates the article properties
 * 
 * @param string $title Title, required
 * @param string $content Content, required
 * @param string $published_at Published date and time, yyyy-mm-dd hh:mm:ss if not blank
 * 
 * @return array An array of validation error messages 
 */

function validateArticle($title, $content, $published_at)
{   // creates empty errors array to ensure that error messages can be apended to it as otherwise
    // it may not exist outside this function
    $errors = [];

        // next ~25 lines validates user input
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

    if ($published_at != '') {

        // creates a datetime obj in the specified format with the value to be converted as the second arg
        $date_time = date_create_from_format('Y-m-d H:i:s', $published_at);

        // pushes error message to errors array if date_time var evaluates to false
        if ($date_time === false) {

            $errors[] = 'Invalid date and/or time';
            
        } else {

            // binds a list of the last errors and warnings to the date_errors var
            $date_errors = date_get_last_errors();
            
            /* checks whether there were any errors i.e. more than 0 errors and if there are, it binds it
            to the errors array which is displayed to user upon them causing an error */
            if ($date_errors['warning_count'] > 0) {
                $errors[] = 'Invalid date and/or time';
            }
        }
    }

    return $errors;
}