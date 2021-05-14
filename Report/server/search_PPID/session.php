<?php
session_start();
$flag=$_POST['flag'];
switch ($flag){
    case 1:
        if ($_SESSION["uflag"]==1){
            echo "1";
        }else {
                echo "0";
            }
        break;
}
?>