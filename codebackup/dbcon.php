<?php

define("HOSTNAME", "localhost");
define("USERNAME", "coramm");
define("PASSWORD", "3BfUo8gLjMd9");
define("DATABASE", "coramm_grocery");

$connection = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DATABASE);

if(!$connection){
    die("Connection Failed");
} 

?>