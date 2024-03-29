<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 10.02.2019
 * Time: 03:30
 */

require_once "../libs/loader.php";

if (!check_login(true)) {
    redirect("/panel/login");
}
setTitle('Duyurular - GiaPanel');

include_once "../models/News.php";
switch ($_GET['action']) {
    case "update":

        redirect("/panel/news");
        break;
    case "add":
        if(!empty($_POST)){
            $data = $_POST;
            if(isset($data['Baslik']) && isset($data['Tanim']) && isset($data['Metin']) && isset($data['Resim'])){
                $data['Service'] = !empty($data['Service']);
                News::add($data);
                addMessage('success','Duyuru başarıyla kayıt edilmiştir.');
                redirect("/panel/news");
            }else{
                addMessage('error','Lütfen tüm alanları doldurunuz!');
            }
        }
        render("news_form",['data'=>$data]);
        break;
    case "sil":
        News::delete($_GET['id']);
        redirect("/panel/news");
        break;
    case "yayinla":
        News::updateStatus($_GET['id'],1);
        redirect("/panel/news");
        break;
    case "kapat":
        News::close($_GET['id']);
        redirect("/panel/news");
        break;
    default:
        $news = News::getAll();
        render('news', ['news' => $news]);
        break;
}