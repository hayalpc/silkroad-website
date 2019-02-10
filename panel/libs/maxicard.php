<?php
/**
 * Created by PhpStorm.
 * User: ekrmn60
 * Date: 8.06.2018
 * Time: 02:20
 */

class MaxiCard{

    public static $RESPONSE = array(
        'ok' => 'Yükleme işlemi başarılı',
        'bayi_hata' => 'Bayi adı veya şifre hatalı',
        'bayi_aktif_hata' => 'Bayi aktif değil',
        'hesap_hata' => 'Bayi hesabı bulunamadı',
        'ip_hata' => 'Bu Ip adresinden işlem yapamazsınız',
        'kod_hata' => 'Kart kodu veya kart şifresi hatalı',
        'kod_tekrar_hata' => 'Kullanılmış Kart kodu',
        'fiyat_hata' => 'Yüklenecek miktar belirsiz veya sistemde kayıtsız miktar',
        'komut_hata' => 'Komut Belirsiz',
        'eksik_alan' => 'Eksik alan var',
        'hata' => 'Hatalı bir işlem yaptınız',
        'veri_hata' => 'Post Bilgisi Gelmedi',
        'api_bilgi' => 'Api Bilgileriniz Eksik',
    );

    public static $API = array(
        'api_user'=>'0ded0bf3e7a83033d80896d35335d9f4',
        'api_pass'=>'VnABcUF#',
        'post_url'=>'https://www.maxigame.com/epin/yukle.php',
    );

    public static function post_xml($url, $xml)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'data=' . urlencode($xml));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        $gelen = curl_exec($ch);
        if (curl_errno($ch)) return false;
        curl_close($ch);
        return $gelen;
    }

    public static function post($post = '')
    {
        $maxigame = self::$API;
        if (!$maxigame['api_user'] || !$maxigame['api_pass'] || !$maxigame['post_url']){
            return 'api_bilgi';
        }
        if (!$post) {
            return 'veri_hata';
        }
        $data = '<?xml version="1.0" encoding="utf-8"?>
	<APIRequest>
		<params>
			<username>' . $maxigame['api_user'] . '</username>
			<password>' . $maxigame['api_pass'] . '</password>
			' . $post . '
		</params>
	</APIRequest>';
        $gelen = self::post_xml($maxigame['post_url'], $data);
        return $gelen;
    }

    public static function epin_yukle($epin)
    {
        if (!$epin){
            return 'veri_hata';
        }
        $post = '<cmd>epinadd</cmd>
            <epinusername>' . $epin['username'] . '</epinusername>
            <epincode>' . $epin['kart_kodu'] . '</epincode>
            <epinpass>' . $epin['kart_sifresi'] . '</epinpass>';
        $gelen = self::post($post);
        return $gelen;
    }

}