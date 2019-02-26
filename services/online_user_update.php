<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 16.02.2019
 * Time: 14:38
 */
include_once __DIR__."/../libs/loader.php";
include_once __DIR__."/../libs/Config.php";
include_once __DIR__."/../libs/DB.php";

$sta = DB::getConnection()->prepare('EXEC FILTER.dbo._UpdatePlayerStatus');

$sta->execute();