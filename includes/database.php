<?php

/**
 * Gets the db connection
 * 
 * @return object Connects to the mysql server
 */
function getDB()
{
$db_host = "localhost";
$db_name = "cms";
$db_user = "cms_www";
$db_pass = "ooSgk2)yoWsYj*z8";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (mysqli_connect_error()) {
    echo mysqli_connect_error();
    exit;
}

return $conn;

}