<?php

@session_start();
if(@$_SESSION["RIGHT"] != "admin"){
    header("Location: ../product_list.php");
}

?>