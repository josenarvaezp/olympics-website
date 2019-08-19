<?php
/* 
This php file sets a connection with the database using an include statement, it then requests an sql statement and echos
the result in a json datastructure. This file is used in order to apply the ajax method $.get
*/
//DATABASE CONNECTION
include "getDB.php";

//GETTING SQL
$sql = $_REQUEST['sql'];
        		
$res = $db->query($sql);

//JSON
echo json_encode($res ->fetchAll());
?>