<?php
$db_name=getenv('dbname');
$db_user=getenv('dbuser');
$db_pass=getenv('dbpass');
$pass=getenv('pass');
// var_dump($dbname);
// var_dump($dbuser);
// var_dump($dbpass);
// var_dump($pass);
define('DB_HOST','localhost');
define('DB_PORT','3307');
define('DB_NAME',$db_name);
define('DB_USER',$db_user);
define('DB_PASS',$db_pass);
?>