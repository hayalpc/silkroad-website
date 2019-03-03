<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 2.03.2019
 * Time: 16:59
 */

require_once "../libs/loader.php";

if (!check_login(true)) {
    redirect("/panel/login");
}
setTitle('Karakterler - GiaPanel');

render('chars');