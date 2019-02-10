<?php
/**
 * Created by IntelliJ IDEA.
 * User: erdinc.karaman
 * Date: 7.06.2018
 * Time: 18:42
 */
require_once "../libs/loader.php";
require_once "../libs/maxicard.php";
require_once "../models/EPinKod.php";

if(!check_login()){
    redirectLogin("/epin-yukle");
}

$user = user();
if(!empty($_POST)){
    if(isset($_POST['g-recaptcha-response'])){
        $captcha  = $_POST['g-recaptcha-response'];
        $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeCbVwUAAAAALJUr9P_xN7Al99yizxFp7wnBk_G&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']));
        if($response->success === true){
            $CardCode = !empty($_POST['CardCode']) ? preg_replace('/[^a-zA-Z0-9\.\-\_]/', '', $_POST['CardCode']) : null;
            $Password = !empty($_POST['Password']) ? preg_replace('/[^a-zA-Z0-9\.\-\_]/', '', $_POST['Password']) : null;

            if($CardCode && $Password){
                $post['username']     = user()->StrUserID;
                $post['kart_kodu']    = $CardCode;
                $post['kart_sifresi'] = $Password;

                $status = 0;
                $amount = 0;
                $bonus  = 0;
                $order  = "";
                $epin   = EPinKod::check($CardCode, $Password);

                if($epin){
                    if($epin->Status == 0){
                        $amount          = intval($epin->Price);
                        $bonus           = $epin->Bonus;
                        $order           = $epin->Order = 1;
                        $epin->Status    = "1";
                        $epin->StrUserID = user()->StrUserID;
                        $status          = 1;
                    } else {
                        addMessage('error', MaxiCard::$RESPONSE['kod_tekrar_hata']);
                        User::addLog(user()->StrUserID, 'E-Pin: ' . MaxiCard::$RESPONSE['kod_tekrar_hata']);
                    }
                } else {
                    $response = MaxiCard::epin_yukle($post);
                    if(!in_array($response, MaxiCard::$RESPONSE)){
                        $data = simplexml_load_string($response);
                        if(trim($data->params->durum) == 'ok' && intval(trim($data->params->siparis_no)) > 0){
                            $order     = intval(trim($data->params->siparis_no));
                            $amount    = trim($data->params->tutar);
                            $amount    = preg_replace('/[^0-9]/', '', $amount);
                            $amount    = intval($amount);
                            $commision = trim($data->params->komisyon);
                            $commision = preg_replace('/[^0-9\.]/', '', $commision);
                            if($amount && $amount > 0){
                                $bonus           = EPinKod::getBonus($amount);
                                $status          = 1;
                                $epin            = new EPinKod();
                                $epin->Val1      = $CardCode;
                                $epin->Val2      = $Password;
                                $epin->Val3      = "";
                                $epin->Status    = 1;
                                $epin->Price     = $amount;
                                $epin->Bonus     = $bonus;
                                $epin->StrUserID = user()->StrUserID;
                            } else {
                                addMessage('error', MaxiCard::$RESPONSE['fiyat_hata']);
                                User::addLog(user()->StrUserID, 'E-Pin: ' . MaxiCard::$RESPONSE['fiyat_hata']);
                            }
                        } else {
                            addMessage('error', MaxiCard::$RESPONSE[trim($data->params->durum)]);
                            User::addLog(user()->StrUserID, 'E-Pin: ' . MaxiCard::$RESPONSE[trim($data->params->durum)]);
                        }
                    } else {
                        addMessage('error', MaxiCard::$RESPONSE[$response]);
                        User::addLog(user()->StrUserID, 'E-Pin: ' . MaxiCard::$RESPONSE[$response]);
                    }
                }

                //TODO: STATUS
                if($status){
                    if(User::addBakiye(user()->StrUserID, $amount + $bonus)){
                        if($epin->ID > 0){
                            $epin->update();
                        } else {
                            $epin->insert();
                        }
                        $user             = User::get(user()->JID);
                        $_SESSION['User'] = $user;
                        User::addLog(user()->StrUserID, "E-Pin: " . ($amount) . ($bonus > 0 ? "+$bonus" : "") . " TL yükleme işleminiz başarıyla gerçekleştirilmiştir.");
                        addMessage('success', "E-Pin: " . ($amount) . ($bonus > 0 ? "+$bonus" : "") . " TL yükleme işleminiz başarıyla gerçekleştirilmiştir.");
                        redirect("/profilim");
                    } else {
                        addMessage("error", "Teknik Hata!<br>Lütfen daha sonra deneyiniz!");
                    }
                }
            } else {
                addMessage('error', 'Lütfen istenilen tüm alanları doldurunuz.');
            }
        } else {
            addMessage("error", "Lütfen captcha doğrulamasını yapınız!");
        }
    } else {
        addMessage("error", "Lütfen captcha doğrulamasını yapınız!");
    }
}

include_once "../views/balance.phtml";