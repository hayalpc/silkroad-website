<?php
/**
 * Created by IntelliJ IDEA.
 * User: erdinc.karaman
 * Date: 3.10.2017
 * Time: 17:12
 */
require_once "../../libs/loader.php";
$_SESSION = null;
session_destroy();
redirect("/panel/login");
