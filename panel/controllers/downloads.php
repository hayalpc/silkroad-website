<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 2.03.2019
 * Time: 13:08
 */
require_once "../libs/loader.php";
require_once "../models/Downloads.php";

if (!check_login(true)) {
    redirect("/panel/login");
}

cache()->delete('getDownload');

setTitle('Dosyalar - GiaPanel');
switch ($_GET['action']) {
    case "update":
        redirect("/panel/downloads");
        break;
    case "add":
        if(!empty($_POST)){
            $data = $_POST;
            if(isset($data['Dosya_Host']) && isset($data['Dosya_Type']) && isset($data['Dosya_Url']) && isset($data['Dosya_Boyut'])){
                Downloads::add($data);
                addMessage('success','Dosya başarıyla kayıt edilmiştir.');
                redirect("/panel/downloads");
            }else{
                addMessage('error','Lütfen tüm alanları doldurunuz!');
            }
        }
        render("downloads_form",['data'=>$data]);
        break;
    case "sil":
        Downloads::delete($_GET['id']);
        redirect("/panel/downloads");
        break;
    default:
        $downloads = Downloads::getAll();
        render('downloads', ['downloads' => $downloads]);
        break;
}
