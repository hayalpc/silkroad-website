<?php
/**
 * Created by PhpStorm.
 * User: ekrmn60
 * Date: 2.06.2018
 * Time: 02:57
 */
require_once "../libs/loader.php";
require_once "../models/Store.php";
require_once "../models/EPinKod.php";
if(!check_login()){
    redirectLogin('/market');
}

switch($_GET['action']){
    case "satin-al":
        if($_GET['id']>0){
            if($_POST['char']) {
                $mall = Store::get($_GET['id']);
                $user = User::get(user()->JID);
                if ($mall && $mall->Fiyat <= $user['BakiyeTL']) {
                    $toplam = EPinKod::bonus($mall->Fiyat);
                    User::harcaBakiye(user()->StrUserID, $mall->Fiyat);
                    $user = json_decode(json_encode(User::get($user['JID'])));
                    $_SESSION['User'] = $user;
                    $con = DB::getConnection();
                    $sql = "exec SRO_VT_SHARD.dbo._ADD_ITEM_EXTERN '" . $_POST['char'] . "','ITEM_ETC_SD_TOKEN_01',$toplam,0";
                    $pre = $con->prepare($sql);
                    $pre->execute();
                    User::addLog(user()->StrUserID, "E-Pin: " . $mall->Fiyat . " TL hesabınızdan düşülüp, {".$_POST['char']."} karakterinize $toplam yüklenmiştir.");
                    addMessage('success','Siparişiniz {'.$_POST['char'].'} karakterinize yüklenmiştir.');
                    redirect("/profilim");
                } else {
                    addMessage('error','Seçilen sipariş için bakiyeniz yetersizdir.');
                    redirect("/market");
                }
            }else{
                include "../views/store-char.phtml";
            }
            die();
        }
        break;
}
$urunler = Store::getMall();
include "../views/store.phtml";
