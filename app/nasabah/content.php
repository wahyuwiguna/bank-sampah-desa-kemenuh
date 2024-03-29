<?php
    if(empty($_REQUEST['ref']))
        $_REQUEST['ref']="dashboard.php";
    
    $link="Pages/".$_REQUEST['ref'];
    include($link);
?>