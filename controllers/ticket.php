<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 25.02.2019
 * Time: 21:35
 */
require_once "../libs/loader.php";
require_once "../models/Tickets.php";

if(!check_login()){
    redirectLogin();
}
switch ($_GET['action']){
    case "yeni":
            if(!empty($_POST) && !empty($_POST['CharName16']) && strlen($_POST['Message']) > 25){
                Tickets::add($_POST['CharName16'],$_POST['Message']);
                redirect('/destek');
            }
        setTitle('Destek Talebi Oluştur');
        $charList = User::getChars(user()->JID);
        render("ticket_form",['chars'=>$charList]);
        break;
    default:
        setTitle('Destek Taleplerim');
        $tickets = Tickets::getAllOwn(user()->JID);
        render("tickets",['tickets'=>$tickets]);
        break;
}

