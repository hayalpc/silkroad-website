<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 9.02.2019
 * Time: 21:54
 */
require_once "../libs/loader.php";
require_once "../models/Tickets.php";
if(isset($_GET['action'])){
    switch ($_GET['action']){
        case "sil":
            Tickets::delete($_GET['id']);
            addMessage('success','Ticket silinmiştir.');
            break;
        case "kapat":
            Tickets::close($_GET['id']);
            break;
        case "yanitla":
            Tickets::updateStatus($_GET['id'],'closed');
            Tickets::add($_GET['id'],$_POST['CharName16'],$_POST['Message']);
            addMessage('success','Cevap kaydedilmiştir.');
            break;
    }
    redirect("/panel/tickets");
    exit();
}
$tickets = Tickets::getAll();

render('tickets',['tickets'=>$tickets]);