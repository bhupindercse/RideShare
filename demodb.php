<?php

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "rs";

try
{
     $DB_con = new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_pass);
     $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $exception)
{
     echo $exception->getMessage();
}

include_once 'class.paging.php';
$paginate = new paginate($DB_con);