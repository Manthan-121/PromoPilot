<?php

include_once ("./includes/config.php");
include (__DIR__."/includes/header.php");

session_start();
unset($_SESSION["id"]);
header("Location: login.php");


include (BASE_URL."/includes/footer.php");
?>