<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 26.02.2019
 * Time: 22:09
 */

include_once __DIR__."/../libs/loader.php";

$list = cache()->getList("",true);

foreach ($list as $item) {
    unlink(DIR_CACHE.$item);
}