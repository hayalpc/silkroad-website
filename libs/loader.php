<?php
/**
 * Created by IntelliJ IDEA.
 * User: erdinc.karaman
 * Date: 29.05.2018
 * Time: 17:03
 */
session_start();
/*if($_GET['beta']){
    $_SESSION['beta'] = 1;
}
if(!isset($_SESSION['beta'])){
    echo "Yakında!<br><br>";
    die();
}*/
require_once "Config.php";
require_once "DB.php";

DB::getConnection();

require_once __DIR__."/../models/User.php";
require_once __DIR__."/../models/Settings.php";

if(Settings::getConfig('BakimModu') == 'on'){
    echo "Bakımda!<br><br>";
    die();
}

setTheme(Settings::getConfig('Theme'));

//$JanganFortress = Settings::getFortress(1);
//$HotanFortress = Settings::getFortress(3);
//$BanditFortress = Settings::getFortress(6);

function runSlack($message = null){
    if(!$message){
        return;
    }
    if(Config::$SLACK) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => Config::$SLACK,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_MAXREDIRS => 1,
            CURLOPT_TIMEOUT => 1,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"text\":\"$message\"}",
        ));
        curl_exec($curl);
        curl_close($curl);
    }
}

function login($admin = false)
{
    if (!check_login($admin))
        redirectLogin($_SERVER['REDIRECT_URL']);
}

function check_login($admin = false)
{
    if ($admin)
        return adminUser() ? true : false;
    else
        return user() ? true : false;
}

/**
 * @return Admin
 */
function user()
{
    if (isset($_SESSION['User'])) {
        return json_decode(json_encode($_SESSION['User']));
    }
    return false;
}

function adminUser()
{
    if (isset($_SESSION['admin'])) {
        return json_decode(json_encode($_SESSION['admin']));
    }
    return false;
}

function redirect($url)
{
    header("Location: " . $url);
}

function redirectLogin($url = null)
{
    header("Location: /giris-yap" . ($url ? "?redirect=" . urlencode($url) : ""));
}

function addMessage($key,$message){
    $_SESSION['message'][$key] = (isset($_SESSION['message'][$key]) ? $_SESSION['message'][$key]."<br>" : "").$message;
}

function getMessage($type,$remove = false) {
    $message = isset($_SESSION['message'][$type]) ? $_SESSION['message'][$type] : "";
    if($remove){
        unset($_SESSION['message'][$type]);
    }
    return $message;
}

function getMessages($remove = false) {
    $a = ['error', 'success', 'info','danger','warning'];
    $messages = [];
    foreach($a as $type) {
        $m = getMessage($type,$remove);
        if(strlen($m))
            $messages[$type] = $m;
    }
    return $messages;
}

function toNonTurkish($text)
{
    return str_replace('İ', 'I', str_replace('ı', 'i',
        str_replace('Ç', 'C', str_replace('ç', 'c',
            str_replace('Ş', 'S', str_replace('ş', 's',
                str_replace('Ğ', 'G', str_replace('ğ', 'g',
                    str_replace('Ü', 'U', str_replace('ü', 'u',
                        str_replace('Ö', 'O', str_replace('ö', 'o', $text))))))))))));
}

function normalizeArray(array $array)
{
    $result = array();
    foreach ($array as $item)
        $result[$item] = $item;
    return $result;
}

function CheckIpRange($ip, $min, $max)
{
    return (ip2long($min) < ip2long($ip) && ip2long($ip) < ip2long($max));
}

function get_client_ip()
{
    if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && $_SERVER["HTTP_X_FORWARDED_FOR"] != "" && $_SERVER["HTTP_X_FORWARDED_FOR"] != "unknown") {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (!empty($_SERVER["HTTP_X_REAL_IP"])) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $ipList = explode(",", $ip);
    $last = array_pop($ipList);
    $last = trim($last);
    if (CheckIpRange($last, "66.249.64.0", "66.249.95.255")) {
        $last = array_pop($ipList);
        $last = trim($last);
    }
    $last = trim($last);
    if (filter_var($last, FILTER_VALIDATE_IP) === false) {
        $last = $_SERVER["REMOTE_ADDR"];
    }
    return $last;
}

function render($view,array $data = null,$return=false,$layout = "main"){
    try{
        $output = renderPartial($view,$data,true);
        if(($layoutFile = getLayoutFile($layout)) !== false) {
            $data['content'] = $output;
            $data['pageTitle'] = $_SESSION['pageTitle'];
            unset($_SESSION['pageTitle']);
            $output = renderFile($layoutFile, $data);
        }
        if($return)
            return $output;
        else
            echo $output;
    }catch(Exception $e){
        return false;
    }
}

function renderPartial($view,$data = null,$return = false){
    if( ($viewFile = getViewFile($view)) !== false) {
        $output = renderFile($viewFile,$data);
        if($return)
            return $output;
        else
            echo $output;
    }else{
        return false;
    }
}

function getViewFile($view){
    $view = trim($view,"/");
    if(is_file(__DIR__."/../views/".getTheme()."/$view.phtml")){
        return __DIR__."/../views/".getTheme()."/$view.phtml";
    }else{
        return false;
    }
}

function renderFile($viewFile,$data) {
    ob_start();
    if(is_array($data))
        extract($data);
    include $viewFile;
    $d = ob_get_clean();
    return $d;
}

function getLayoutFile($layout) {
    if(!strlen($layout))
        return false;
    if(substr($layout,0,1) != "/"){
        $layout = "layouts/$layout";
    }else{
        $layout = trim($layout,"/");
    }
    if(is_file(__DIR__."/../views/".getTheme()."/$layout.phtml")){
        return __DIR__."/../views/".getTheme()."/$layout.phtml";
    }else{
        return false;
    }
}

function getTitle(){
    return $_SESSION['title'];
}
function setTitle($title){
    $_SESSION['title'] = $title;
}
function getTheme(){
    return $_SESSION['theme'];
}
function setTheme($theme){
    $_SESSION['theme'] = $theme;
}

function pre($a){
    echo "<pre>";
    print_r($a);
    echo "</pre>";
}

function diepre($a){
    pre($a);
    die();
}