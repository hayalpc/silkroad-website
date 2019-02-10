<?php
/**
 * Created by IntelliJ IDEA.
 * User: erdinc.karaman
 * Date: 29.05.2018
 * Time: 17:00
 */

class DB
{
    private static $connection = NULL;

    public static function getConnection()
    {
        if (!self::$connection) {
            $dsn = "sqlsrv:server=".Config::$dbHost;
            $username = Config::$dbUsername;
            $password = Config::$dbPassword;
            try {
                self::$connection = new PDO($dsn, $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch (Exception $e){
                echo "Bir hata ile karşılaşıldı. Lütfen daha sonra tekrar deneyiniz!";
                runSlack($e->getMessage());
                die();
            }
        }
        return self::$connection;
    }
}
