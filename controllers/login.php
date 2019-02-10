<?php
/**
 * Created by IntelliJ IDEA.
 * User: erdinc.karaman
 * Date: 3.10.2017
 * Time: 17:12
 */
require_once "../libs/loader.php";
if(check_login()){
    redirect("/profilim");
}
if(!empty($_POST)){
    if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
        $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeCbVwUAAAAALJUr9P_xN7Al99yizxFp7wnBk_G&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']));
        if ($response->success === true) {
            if(!empty($_POST['UserName']) && !empty($_POST['Password'])){
                $user = User::login($_POST['UserName'], $_POST['Password']);
                if($user){
                    User::addLog($user['StrUserID'],'Giriş Yapıldı.');
                    $_SESSION['User'] = $user;
                    redirect(isset($_GET['redirect']) ? urldecode($_GET['redirect']) : "/profilim");
                }else{
                    addMessage('error','Lütfen giriş bilgileriniz kontrol ediniz.');
                }
            }else{
                addMessage('error','Lütfen istenilen tüm alanları doldurunuz.');
            }
        } else {
            addMessage("error","Lütfen captcha doğrulamasını yapınız!");
        }
    } else {
        addMessage("error","Lütfen captcha doğrulamasını yapınız!");
    }
}
include "../views/login.phtml";