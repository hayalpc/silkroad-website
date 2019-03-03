<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 13.02.2019
 * Time: 21:29
 */
include_once __DIR__."/../libs/Config.php";
include_once __DIR__."/../libs/DB.php";
include_once __DIR__."/../models/User.php";

$list = User::getJobHonorBuffList();

//print_r($list);

