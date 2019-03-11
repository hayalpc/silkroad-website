<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 10.03.2019
 * Time: 02:36
 */
require_once "../libs/loader.php";
require_once "../models/Char.php";

if(!check_login()){
    redirectLogin();
}


if(!empty($_POST['CharName'])){
    Char::bugKurtar($_POST['CharName']);
    addMessage('success',$_POST['CharName']." bugtan kurtarma başarılı.");
    redirect("/profilim");
}
render("bugtan-kurtar",['charList'=>User::getChars(user()->JID)]);