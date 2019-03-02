<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 2.03.2019
 * Time: 02:03
 */

include_once "../libs/loader.php";
setTitle('Şifre Sıfırla');
if(!empty($_POST)){
    addMessage('error','Şifre sıfırlama şuan aktif değildir.');
}
render("reset-password");