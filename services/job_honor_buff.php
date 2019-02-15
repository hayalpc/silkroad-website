<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 13.02.2019
 * Time: 21:29
 */
include_once "../libs/Config.php";
include_once "../libs/DB.php";
include_once "../models/User.php";

$list = User::getJobHonorBuffList();

//print_r($list);

