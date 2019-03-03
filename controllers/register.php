<?php
/**
 * Created by PhpStorm.
 * User: ekrmn60
 * Date: 31.05.2018
 * Time: 02:09
 */
require_once "../libs/loader.php";

if (user()) {
    redirect("/profilim");
}

//addMessage("error","Açılış nedeniyle üyelikler durdurulmuştur.");
//include_once "../views/errorMessage.phtml";
//die();
setTitle('Kayıt Ol');
if (!empty($_POST)) {
    $UserName = $_POST["UserName"];
    $Password1 = $_POST["Password1"];
    $Password2 = $_POST["Password2"];
    $GizliYanit = $_POST["GizliYanit"];
    $Email = $_POST["Email"];
    $Sozleme = $_POST["Sozleme"];

    if (isset($_POST['g-recaptcha-response']) || true) {
        $captcha = $_POST['g-recaptcha-response'];
        $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeCbVwUAAAAALJUr9P_xN7Al99yizxFp7wnBk_G&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']));
        if (true || $response->success === true) {
            if (isset($_POST['Sozleme'])) {
                if (!empty($UserName) && !empty($Password1) && !empty($Password2) && !empty($GizliYanit) && !empty($Email)) {
                    if (strlen($UserName) > 3 && strlen($UserName) <= 16 && preg_match('/[^a-zA-Z0-9_-]/', $UserName) == 0) {
                        if (strlen($Password1) > 3 && strlen($Password1) <= 16) {
                            if ($Password1 == $Password2) {
                                if (strlen($GizliYanit) > 3 && strlen($GizliYanit) <= 16 && preg_match('/[^a-zA-Z0-9_-]/', $GizliYanit) == 0) {
                                    if (filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                                        $HesapKontrol = User::checkUsername($UserName);
                                        if (!$HesapKontrol) {
                                            $MailKontrol = User::checkEmail($Email);
                                            if (!$MailKontrol) {
                                                $user = new User();
                                                $user->StrUserID = $UserName;
                                                $user->password = md5($Password1);
                                                $user->Email = $Email;
                                                $user->certificate_num = $GizliYanit;
                                                $user->sec_primary = 3;
                                                $user->sec_content = 3;
                                                if ($user->addUser() !== false) {
                                                    User::addSilk($user->JID, 500000,25);
                                                    User::addBakiye($user->StrUserID, 0);
                                                    $login = User::login($user->StrUserID, $Password1);
                                                    $_SESSION['User'] = $login;
                                                    User::addLog($user->StrUserID,'Hesap açılışı tamamlandı.');
                                                    addMessage("success","Tebrikler Kaydınız Başarıyla Oluşturuldu!");
                                                    redirect("/profilim");
                                                } else {
                                                    addMessage("error","Hesap oluşturulurken bir hata ile karşılaşıldı.");
                                                }
                                            } else {
                                                addMessage("error","Girmiş Olduğunuz Kullanıcı Adı Zaten Kullanılmakta!");
                                            }
                                        } else {
                                            addMessage("error","Girmiş Olduğunuz Kullanıcı Adı Zaten Kullanılmakta!" );
                                        }
                                    } else {
                                        addMessage("error","Lütfen Geçerli Bir Mail Adresi Giriniz! ");
                                    }
                                } else {
                                    addMessage("error","1. GizliYanit  4 Karakterden Küçük 16 Karakterden Büyük Olamaz<br>2. GizliYanit Türkçe Karakter içeremez!");
                                }
                            } else {
                                addMessage("error","Şifre ve Şifre Tekrarı Uyuşmuyor!");
                            }
                        } else {
                            addMessage("error","Şifreniz 4 Karakterden Küçük 16 Karakterden Büyük Olamaz!");
                        }
                    } else {
                        addMessage("error","1. Kullanıcı Adı 4 Karakterden Küçük 16 Karakterden Büyük Olamaz<br>2. Kullanıcı Adı Türkçe Karakter içeremez!");
                    }
                } else {
                    addMessage("error","Lütfen Boş Alan Bırakmayınız!");
                }
            } else {
                addMessage("error","Lütfen Üyelik Sözleşmesini onaylayınız!");
            }
        } else {
            addMessage("error","Lütfen captcha doğrulamasını yapınız!");
        }
    } else {
        addMessage("error","Lütfen captcha doğrulamasını yapınız!");
    }
}
render("register");