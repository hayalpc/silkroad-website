<?php
/**
 * Created by PhpStorm.
 * User: ekrmn60
 * Date: 1.06.2018
 * Time: 00:46
 */

require_once "../libs/loader.php";

if (!check_login()) {
    redirectLogin();
}
$user = user();
setTitle('Profilim');
switch ($_GET['action']) {
    case 'gecmis':
        setTitle('Hesap Geçmişi');
        $histories = User::getHistory($user->StrUserID);
        render('profile-history',['histories'=>$histories]);
        break;
    case "sifre-degistir":
        if(!empty($_POST)){
            $Password = $_POST["Password"];
            $Password1 = $_POST["Password1"];
            $Password2 = $_POST["Password2"];
            $GizliYanit = $_POST["GizliYanit"];
            if (isset($_POST['g-recaptcha-response'])) {
                $captcha = $_POST['g-recaptcha-response'];
                $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeCbVwUAAAAALJUr9P_xN7Al99yizxFp7wnBk_G&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']));
                if ($response->success === true || true) {
                    if(user()->certificate_num == $GizliYanit){
                        if(user()->password == md5($Password)){
                            if($Password1 == $Password2){
                                User::addLog($user->StrUserID,'Şifre Değiştirildi.');
                                User::updatePassword(user()->JID,$Password1);
                                addMessage("success","Şifre değiştirme işlemi başarıyla gerçekleştirildi!");
                                redirect("/profilim");
                            }else{
                                addMessage('error','Yeni şifreler eşleşmiyor. Lütfen kontrol ediniz!');
                            }
                        }else{
                            addMessage('error','Lütfen mevcut şifrenizi giriniz!');
                        }
                    }else{
                        addMessage('error','Lütfen Geçerli GizliYanıt Giriniz! ');
                    }
                }else{
                    addMessage('error','Lütfen captcha doğrulamasını yapınız!');
                }
            }else{
                addMessage('error','Lütfen captcha doğrulamasını yapınız!');
            }
        }
        setTitle('Şifre Değiştir');
        render('profile-password');
        break;
    default:
        render('profile',['user'=>user()]);
        break;
}
