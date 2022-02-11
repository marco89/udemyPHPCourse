<?php

/**
 * Database
 * 
 * A connection to the database
 */
class Database
{
    /**
     * Get the database connection
     * 
     * @return PDO object Connection to the database server
     */
    public function getDB()
    {
        $db_host = "localhost";
        $db_name = "cms";
        $db_user = "cms_www";
        $db_pass = "ooSgk2)yoWsYj*z8";

        // specifies the type, host and name of db as well as what charset
        $dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8';

        // creates a new PDO object 
        return new PDO($dsn, $db_user, $db_pass);
    }
}