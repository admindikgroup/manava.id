<?php
error_reporting(0);
//error_reporting(E_ERROR | E_PARSE);
ob_start();
error_reporting(0);



if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {

define('HOST2','localhost');
define('USER2','root');
define('PASS2','');
define('DB2', 'dggroup');

} else {
define('HOST2','localhost');
define('USER2','dggroupi_management');
define('PASS2','DgGroup123!');
define('DB2', 'dggroupi_management');
}






$db2 = new mysqli(HOST2, USER2, PASS2, DB2);


// define('HOST2','localhost');
// define('USER2','dggroupi_quiz');
// define('PASS2','MrQuizDgGroup123!');
// define('DB2', 'dggroupi_quiz');


// $db2 = new mysqli(HOST2, USER2, PASS2, DB2);


?>