<?php
/**
 * Created by IntelliJ IDEA.
 * User: erdinc.karaman
 * Date: 7.02.2019
 * Time: 12:54
 */
require_once "../libs/loader.php";
require_once "../models/Settings.php";

if (!check_login(true)) {
    redirect("/panel/login");
}
$settings = Settings::get();
if(!empty($_POST)){
    $data = $_POST;
    foreach ($settings as $item=>$dd) {
        if($item == 'ID')
            continue;
        if(empty($data[$item])){
            $settings->{$item} = "";
        }else{
            $settings->{$item} = $data[$item];
        }
    }
    if($settings->update()){
        addMessage('success','Ayarlarınız kayıt edilmiştir.');
        redirect('/panel/settings');
        exit();
    }else{
        addMessage('error','Ayarlarınız kayıt edilemedi.');
    }
}

setTitle('Ayarlar - GiaPanel');
render('settings',['settings'=>$settings]);