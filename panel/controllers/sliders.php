<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 10.02.2019
 * Time: 03:30
 */

include_once "../libs/loader.php";
include_once "../models/Sliders.php";
switch ($_GET['action']) {
    case "update":

        redirect("/panel/sliders");
        break;
    case "add":
        if(!empty($_POST)){
            $data = $_POST;
            if(isset($data['Title']) && isset($data['Description']) && isset($data['ResimUrl']) && isset($data['Url']) && isset($data['Thumb'])){
                $data['Service'] = !empty($data['Service']);
                Sliders::add($data);
                addMessage('success','Slider başarıyla kayıt edilmiştir.');
                redirect("/panel/sliders");
            }else{
                addMessage('error','Lütfen tüm alanları doldurunuz!');
            }
        }
        render("sliders_form",['data'=>$data]);
        break;
    case "sil":
        Sliders::delete($_GET['id']);
        redirect("/panel/sliders");
        break;
    case "yayinla":
        Sliders::updateStatus($_GET['id'],1);
        redirect("/panel/sliders");
        break;
    case "kapat":
        Sliders::close($_GET['id']);
        redirect("/panel/sliders");
        break;
    default:
        $sliders = Sliders::getAll();
        render('sliders', ['sliders' => $sliders]);
        break;
}