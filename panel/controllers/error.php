<?php
/**
 * Created by PhpStorm.
 * User: ekrmn60
 * Date: 4.06.2018
 * Time: 23:30
 */
require_once "../libs/loader.php";

$img = "";
switch ($_GET['action']){
    case "404":
        $message = "Aradığınız sayfa bulunamadı!";
        addMessage('error',$message);
        break;

}
include_once "../views/errorMessage.phtml";