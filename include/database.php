<?php
   session_start();
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'attendance');
   define('DB_PASSWORD', 'ujadinfDGAFSNOUIJ439187');
   define('DB_DATABASE', 'attendance');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
?>