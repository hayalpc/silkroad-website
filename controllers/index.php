<?php
/**
 * Created by IntelliJ IDEA.
 * User: erdinc.karaman
 * Date: 29.05.2018
 * Time: 17:02
 */

require_once "../libs/loader.php";
setTitle('Anasayfa');
$_GET['slider'] = 1;
render("index");
