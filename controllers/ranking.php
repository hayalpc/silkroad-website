<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 22.02.2019
 * Time: 01:39
 */
require_once "../libs/loader.php";
require_once "../models/Rank.php";
require_once "../models/Char.php";

setTitle('Rank');
switch ($_GET['action']){
    case "char":
        $id = $_GET['id'];
        $data['char'] = Char::get($id);
        $data['items'] = Char::generateItemList(Char::getItems($id));
        $data['uniques'] = Char::getUniques($id);
        $data['globals'] = Char::getGlobals($id);
        render("char_rank",$data);
        break;
    default:
        $data['players'] = Rank::getPlayer();
        $data['guilds'] = Rank::getGuild();
        $data['jobTrader'] = Rank::getJob(Rank::TRADER);
        $data['jobHunter'] = Rank::getJob(Rank::HUNTER);
        $data['jobThief'] = Rank::getJob(Rank::THIEF);
        render("ranking",$data);
        break;
}

