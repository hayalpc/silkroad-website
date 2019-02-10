<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 5.02.2019
 * Time: 21:12
 */
require_once "../libs/loader.php";

if (!check_login(true)) {
    redirect("/panel/login");
}
setTitle('Anasayfa - GiaPanel');
render('index');