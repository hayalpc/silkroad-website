<?php
/**
 * Created by IntelliJ IDEA.
 * User: erdinc.karaman
 * Date: 3.10.2017
 * Time: 17:12
 */
require_once "../libs/loader.php";
require_once "../models/Admin.php";

if(check_login(true)){
    redirect("/panel");
}
if(!empty($_POST)){
    if(!empty($_POST['username']) && !empty($_POST['password'])){
        $user = Admin::login($_POST['username'], $_POST['password']);
        if($user){
            $_SESSION['admin'] = $user;
            redirect(isset($_GET['redirect']) ? urldecode($_GET['redirect']) : "/panel");
        }else{
            addMessage('error','Lütfen giriş bilgileriniz kontrol ediniz.');
        }
    }else{
        addMessage('error','Lütfen istenilen tüm alanları doldurunuz.');
    }
}
renderPartial("login");