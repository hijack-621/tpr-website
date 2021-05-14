<?php
/**
 * Created by PhpStorm.
 * User: Iori
 * Date: 2020/1/8
 * Time: 8:58
 */
session_start();
$flag = $_POST['forfaca'];
$mysqli=null;
include '../../../db/new_link_db.php';

if($mysqli -> connect_errno){
    echo 'link error'.$mysqli -> connect_error;
    return;
}
if($flag==1){

}
